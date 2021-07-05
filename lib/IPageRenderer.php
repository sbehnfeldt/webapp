<?php


namespace Sbehnfeldt\Webapp;


interface IPageRenderer
{
    const PAGE_INDEX = 0;

    public function render(int $page, array $context = []) : string;
}
