<?php

declare(strict_types=1);

namespace Tcds\Io\Player;

use Exception;

readonly class Layer
{
    /**
     * @param array<string> $namespaces
     * @return array<string, array<string>>
     */
    public function check(string $basepath, string $layer, array $namespaces): array
    {
        $directory = rtrim("$basepath/$layer", '/');
        $files = $this->rglob("$directory/*.php");
        $leaking = [];

        foreach ($files as $file) {
            $value = $this->checkFile($file, $namespaces);

            if ($value === []) {
                continue;
            }

            $leaking[$file] = $value;
        }

        return $leaking;
    }

    /**
     * @param array<string> $namespaces
     * @return array<string>
     */
    private function checkFile(string $file, array $namespaces): array
    {
        $classContent = file_get_contents($file) ?: throw new Exception("Could not load file <$file>");
        $lines = explode("\n", $classContent);
        $uses = array_filter(
            array: $lines,
            callback: fn(string $use) => str_starts_with(trim($use), "use "),
        );

        /**
         * At least for now, we want to allow php standard classes to be used, it might change in the future
         */
        $leaking = array_filter(array: $uses, callback: fn(string $use) => str_contains($use, "\\"));

        foreach ($namespaces as $namespace) {
            $leaking = array_filter(
                array: $leaking,
                callback: fn(string $use) => !str_contains($use, $namespace),
            );
        }

        return array_map(
            fn(string $use) => str_replace('use ', '- ', rtrim($use, ';')),
            array_values($leaking),
        );
    }

    /**
     * @return array<string>
     */
    private function rglob(string $pattern, int $flags = 0): array
    {
        $files = glob($pattern, $flags);

        if (!$files) {
            $files = [];
        }

        $directories = glob(dirname($pattern) . '/*', GLOB_ONLYDIR | GLOB_NOSORT);

        if (!$directories) {
            $directories = [];
        }

        return array_reduce($directories, function (array $files, string $dir) use ($pattern, $flags): array {
            return array_merge(
                $files,
                $this->rglob($dir . '/' . basename($pattern), $flags),
            );
        }, $files);
    }
}
