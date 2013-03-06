<?php
class Company extends AppModel
{
    public $belongsTo = array('User', 'State');
}
