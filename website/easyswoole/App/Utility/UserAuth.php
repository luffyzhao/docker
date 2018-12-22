<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/22
 * Time: 12:57
 */

namespace App\Utility;


use App\Utility\UserAuth\Parse;
use EasySwoole\EasySwoole\Config;
use EasySwoole\Component\Openssl;

class UserAuth
{
    protected $openssl;

    public function __construct($key = '')
    {
        if ($key === '') {
            $opensslConfig = Config::getInstance()->getConf('OPENSSL');
            $key = $opensslConfig['KEY'];
        }
        $this->openssl = new Openssl($key, 'DES-EDE3');
    }

    /**
     * 验证
     * @param string $token
     * @return Parse
     * @throws \Exception
     */
    public function verify(string $token): Parse
    {
        $parse = $this->decrypt($token);

        if (!$parse->verify()) {
            throw new \Exception('token expiration');
        }

        return $parse;
    }

    /**
     * 加密
     * @param Parse $data
     * @return string
     */
    public function encrypt(Parse $data): string
    {
        return $this->openssl->encrypt(serialize($data));
    }

    /**
     * 解密
     * @param string $encode
     * @return Parse
     * @throws \Exception
     */
    public function decrypt(string $encode): Parse
    {
        $parseStr = $this->openssl->decrypt($encode);
        $parse = @unserialize($parseStr);
        if ($parse !== false || $parse instanceof Parse) {
            return $parse;
        }
        throw new \Exception('decrypt error!');
    }
}