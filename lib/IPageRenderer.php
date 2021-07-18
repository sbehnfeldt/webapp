<?php


namespace Sbehnfeldt\Webapp;


interface IPageRenderer
{
    const PAGE_LOGIN = 0;
    const PAGE_INDEX = 1;
    const PAGE_REPORTS = 2;
    const PAGE_USERS = 3;
    const PAGE_GROUPS = 4;
    const PAGE_SECURITY = 5;
    const PAGE_ADMIN = 6;
    const PAGE_PROFILE = 7;
    const HTTP_401 = 8;

    public function render(int $page, array $context = []) : string;
}
