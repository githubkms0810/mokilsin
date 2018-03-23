<?php 
namespace captcha;
defined('BASEPATH') OR exit('No direct script access allowed');
interface ICaptchaSolver
{
    function report(string $captchaId);
    function request();
    function response(string $captchaId);
    function isError(string $captchaId);
}
?>