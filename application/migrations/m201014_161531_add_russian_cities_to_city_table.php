<?php

use yii\db\Migration;
use yii\db\Query;
use yii\console\Exception;
use yii\helpers\Console;

/**
 * Class m201014_161531_add_russian_cities_to_city_table
 */
class m201014_161531_add_russian_cities_to_city_table extends Migration
{
    const TABLE = '{{%city}}';
    private $dataFile;

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     */
    public function __construct($config = [])
    {
        parent::__construct($config);

        $dataFilePath = __DIR__ . '/migration_data/m201014_161531_city.csv';

        if (!file_exists($dataFilePath)) {
            throw new Exception('Data file not found');
        }

        $this->dataFile = new \SplFileObject($dataFilePath);
        $this->dataFile->setCsvControl(';');
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function safeUp()
    {
        $country = (new Query())
            ->select(['id'])
            ->from('{{%country}}')
            ->where(['slug' => 'rossiya'])
            ->limit(1)
            ->one();

        if (is_null($country)) {
            throw new Exception('Russia country not found!');
        }

        $countryId = (int)$country['id'];

        while ($fileRow = $this->dataFile->fgetcsv()) {
            $city = $this->getDataFromFileRow($fileRow);

            if (strlen($city['title']) > 0 && strlen($city['code']) > 0) {
                Console::output(sprintf('Inserting %s %s', $city['title'], $city['code']));

                $this->db->createCommand()->insert(self::TABLE, [
                    'name' => $city['title'],
                    'sort_order' => 0,
                    'slug' => $city['code'],
                    'country_id' => $countryId,
                ])->execute();
            } elseif (
                !$this->dataFile->eof() && // not end file
                !(strlen($city['title']) == 0 && strlen($city['code']) == 0) // title and code not eq zero
            ) {
                throw new Exception(sprintf(
                    'Error add city. Error in params: title - "%s" or code - "%s"',
                    $city['title'],
                    $city['code']
                ));
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     * @throws \yii\db\Exception
     */
    public function safeDown()
    {
        while ($fileRow = $this->dataFile->fgetcsv()) {
            $city = $this->getDataFromFileRow($fileRow);

            if (strlen($city['code']) > 0) {
                Console::output(sprintf('Deleting %s %s', $city['title'], $city['code']));

                $this->db->createCommand()->delete(self::TABLE, ['slug' => $city['code']])->execute();
            } elseif (
                !$this->dataFile->eof() && // not end file
                !(strlen($city['title']) == 0 && strlen($city['code']) == 0) // title and code not eq zero
            ) {
                throw new Exception(sprintf(
                    'Error delete city, empty city code. Params: title - "%s", code - "%s"',
                    $city['title'],
                    $city['code']
                ));
            }
        }

        return true;
    }

    /**
     * Prepare city code to insert to db.
     *
     * Delete space before and after code.
     * Replace space inside code on "_".
     * Replace all chars except "a-z", "-", "_" on void.
     * Convert to lower case string.
     *
     * @param string $code
     *
     * @return string|string[]|null
     */
    private function prepareCityCode($code)
    {
        return preg_replace(
            ['/[\s]+/', '/[^a-z\-\_]+/'],
            ['_', ''],
            strtolower(trim($code))
        );
    }

    /**
     * Extract data from file row and prepare it.
     *
     * @param array $row
     *
     * @return array
     */
    private function getDataFromFileRow($row)
    {
        return [
            'title' => isset($row[0]) ? trim($row[0]) : '',
            'code' => isset($row[1]) ? $this->prepareCityCode($row[1]) : '',
        ];
    }
}
