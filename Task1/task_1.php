<?php

$inputFile = 'D:/Projects/TestMarketingLogic/Task1/source_300.csv';
$outputFile = 'D:/Projects/TestMarketingLogic/Task1/matrix.csv';
$size = 300;

/**
 * Создает пустую матрицу заданного размера, заполненную нулями.
 *
 * @param int $size Размер матрицы.
 * @return array Двумерный массив с нулями.
 */
function initializeMatrix(int $size): array
{
    return array_fill(0, $size, array_fill(0, $size, 0));
}

/**
 * Заполняет матрицу значениями из CSV файла.
 *
 * @param string $inputFile Путь к входному CSV файлу.
 * @param array $matrix Ссылка на матрицу для заполнения.
 * @param int $size Размер матрицы.
 * @return void
 * @throws Exception
 */
function fillMatrixFromCsv(string $inputFile, array &$matrix, int $size): void
{
    if (!file_exists($inputFile)) {
        throw new Exception("Файл не найден: $inputFile");
    }

    if (($handle = fopen($inputFile, 'r')) !== false) {
        while (($data = fgetcsv($handle, 0, '|')) !== false) {
            if (count($data) >= 2) {
                $cellId = (int)$data[0];
                $value = (int)$data[1];

                $row = intdiv($cellId - 1, $size);
                $col = ($cellId - 1) % $size;
                $matrix[$row][$col] = $value;
            }
        }
        fclose($handle);
    } else {
        throw new Exception("Ошибка при открытии файла: $inputFile");
    }
}

/**
 * Записывает матрицу в CSV файл.
 *
 * @param string $outputFile Путь к выходному CSV файлу.
 * @param array $matrix Матрица для записи.
 * @return void
 * @throws Exception
 */
function writeMatrixToCsv(string $outputFile, array $matrix): void
{
    if (($outputHandle = fopen($outputFile, 'w')) !== false) {
        foreach ($matrix as $row) {
            fputcsv($outputHandle, $row);
        }
        fclose($outputHandle);
    } else {
        throw new Exception("Ошибка при открытии файла для записи: $outputFile");
    }
}

try {
    $matrix = initializeMatrix($size);
    fillMatrixFromCsv($inputFile, $matrix, $size);
    writeMatrixToCsv($outputFile, $matrix);
    echo "Матрица успешно записана в файл $outputFile.\n";
} catch (Exception $e) {
    echo "Произошла ошибка: " . $e->getMessage() . "\n";
}
