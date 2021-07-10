<?php


namespace Sbehnfeldt\Webapp;


interface IPageRenderer
{
    const PAGE_INDEX = 0;
    const PAGE_LOGIN = 1;
    const HTTP_401 = 2;

    public function render(int $page, array $context = []) : string;
}
