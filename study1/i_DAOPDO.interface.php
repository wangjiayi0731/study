<?php
interface i_DAOPDO{
    //查询全部
    public function fetchAll($sql);
    //查询单条
    public function fetchRow($sql);
    //查询某个字段
    public function fetchOne($sql);
    //增删改
    public function query($sql);
    //添加引导
    public function quote($data);
    //获取增加成功的id号
    public function getInsertId();
}