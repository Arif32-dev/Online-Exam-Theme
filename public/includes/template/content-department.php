<?php
class Department_sec
{
    private $table;
    private $dept_data;
    public function __construct()
    {
        global $wpdb;
        $this->table = $wpdb->prefix . 'department';
        $this->dept_data = $wpdb->get_results("SELECT * FROM " . $this->table . "");
        $this->dept_sec();
    }
    public function dept_sec()
    {
        foreach ($this->dept_data as $dept) {
            echo '<a>' . $dept->dept_name . '</a>';
        };
    }
}
new Department_sec();
