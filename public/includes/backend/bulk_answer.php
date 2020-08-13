<?php
require_once dirname(dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))))) . '/wp-load.php';
require_once get_theme_file_path() . '/public/includes/class/class-base-answer.php';

class OE_qus_bulk_answer extends OE_Base_answer
{
    private $data;
    public function __construct()
    {
        $this->data = $_POST;
        if (!$this->data['final_data']) {
            return;
        }
        foreach ($this->data['final_data'] as $key) {
            if (!$key) {
                return;
            }
            $this->insert_bulk_answer($key);
        }
    }

    /**
     * @method is going to insert answer in bulk
     * @param array $qus_data
     * @return void
     */
    public function insert_bulk_answer(array $qus_data)
    {
        if ($this->insert_answer(get_current_user_id(), $qus_data[0]['value'], $qus_data[1]['value'], false)) {
            /* if all qustion answer is submitted then check user qus will return false and i will make it true */
            if (!$this->check_user_qus($qus_data[0]['value'], get_current_user_id())) {
                if ($this->update_qustion_folder($qus_data[0]['value'])) {
                    echo $qus_data[0]['value'];
                } else {
                    echo $qus_data[0]['value'];
                }
            }
        } else {
            echo 'failed';
        }
    }
}
new OE_qus_bulk_answer();
