<?php

use yii\db\Migration;

/**
 * Class m180720_094313_insert_meta_data
 */
class m180720_094313_insert_meta_data extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('{{%meta_data}}',['meta_key','meta_value'],[

            ['service_title', 'Магазин тренажеров eurosport.com.ua'],
            ['service_description', 'Большой выбор, индивидуальный подход и правильный подбор каждому'],

            ['service_first_item_title', 'Коммерческое оборудование'],
            ['service_first_item_description', 'Просчет стоимости проффессиональных тренажеров для залов'],

            ['service_second_item_title', 'Выставочный зал'],
            ['service_second_item_description', 'Возможность увидеть, протестировать тренажер, перед покупкой.'],

            ['service_third_item_title', 'Официальная гарантия'],
            ['service_third_item_description', 'Пост-гарантийное обслуживание тренажеров ТОЛЬКО своих клиентов'],

            ['sale_title', 'Спец предложение'],
            ['sale_description', 'Регулярное проведений акций, также пополнение новыми товарами в магазине тренажеров ЕВРОСПОРТ'],

            ['about_title', 'О нас'],
            ['about_first_description', 'Большой выбор качественных тренажеров, для дома, офиса или тренажерного зала'],
            ['about_second_description', 'Первый магазин тренажеров в Харькове. Более 15 лет на рынке спортивного оборудования.'],

            ['contact_title', 'Адресс'],
            ['contact_address', 'г. Харьков, ул. Красношкольная набережная, 4'],
            ['contact_phone', '050-591-555-0'],

            ['seo_title', 'Магазин тренажеров ЕВРОСПОРТ'],
            ['seo_keywords', 'купить тренажеры в харькове,беговая дорожка купить,орбитрек цена'],
            ['seo_description', 'Магазин тренажеров ЕВРОСПОРТ - 15 лет опыта подбора тренажеров'],

        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->truncateTable('{{%meta_data}}')->execute();
    }
}
