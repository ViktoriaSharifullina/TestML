<?php

class Simulation
{
    private const TOTAL_PEOPLE = 20;
    private const GROUP_SIZE = 10;
    private array $people;
    private int $iterations;

    /**
     * Simulation constructor.
     * @param int $iterations Количество итераций для симуляции.
     */
    public function __construct(int $iterations = 100000)
    {
        if ($iterations <= 0) {
            throw new InvalidArgumentException('Количество итераций должно быть положительным.');
        }

        $this->people = range(1, self::TOTAL_PEOPLE);
        $this->iterations = $iterations;
    }

    /**
     * Перемешивает массив людей и делит их на две группы.
     *
     * @return array Две группы людей.
     */
    private function shuffleAndGroup(): array
    {
        shuffle($this->people);
        $group1 = array_slice($this->people, 0, self::GROUP_SIZE);
        $group2 = array_slice($this->people, self::GROUP_SIZE, self::GROUP_SIZE);
        return [$group1, $group2];
    }

    /**
     * Запускает симуляцию и возвращает вероятность того, что 19 и 20 окажутся в одной группе.
     *
     * @return float Вероятность в диапазоне от 0 до 1.
     */
    public function runSimulation(): float
    {
        $sameGroupCount = 0;

        for ($i = 0; $i < $this->iterations; $i++) {
            list($group1, $group2) = $this->shuffleAndGroup();

            if ((in_array(19, $group1) && in_array(20, $group1)) || (in_array(19, $group2) && in_array(20, $group2))) {
                $sameGroupCount++;
            }
        }

        return $sameGroupCount / $this->iterations;
    }
}

try {
    $simulation = new Simulation();
    $probability = $simulation->runSimulation();
    echo "Вероятность того, что 19 и 20 окажутся в одной группе: " . ($probability * 100) . "%\n";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage() . "\n";
}
