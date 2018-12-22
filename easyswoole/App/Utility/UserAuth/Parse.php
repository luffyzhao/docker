<?php
/**
 * Created by PhpStorm.
 * User: luffyzhao
 * Date: 2018/12/22
 * Time: 13:57
 */

namespace App\Utility\UserAuth;


class Parse
{
    /**
     * 过期时间
     * @var null|int
     */
    protected $expiration = null;

    /**
     * ID
     * @var null|int
     */
    protected $uid = null;

    /**
     * 用户登录凭证 存redis 
     * @var null
     */
    protected $authKey = null;


    /**
     * 身份
     * @var null|string
     */
    protected $type = null;

    /**
     * 额外参数
     * @var array
     */
    protected $extra = [];

    public function __construct(array $parse)
    {
        if(isset($parse['expiration'])){
            $this->setExpiration($parse['expiration']);
            unset($parse['expiration']);
        }
        
        if(isset($parse['uid'])){
            $this->setUid($parse['uid']);
            unset($parse['uid']);
        }

        if(isset($parse['authKey'])){
            $this->setAuthKey($parse['authKey']);
            unset($parse['authKey']);
        }

        if(isset($parse['type'])){
            $this->setType($parse['type']);
            unset($parse['type']);
        }

        $this->setExtra($parse);
    }

    /**
     * 验证
     * @return bool
     */
    public function verify() : bool{
        if($this->expiration < time()){
            return false;
        }
        return true;
    }

    /**
     * @return int|null
     */
    public function getExpiration(): ?int
    {
        return $this->expiration;
    }

    /**
     * @param int|null $expiration
     */
    public function setExpiration(?int $expiration): void
    {
        $this->expiration = $expiration;
    }

    /**
     * @return int|null
     */
    public function getUid(): ?int
    {
        return $this->uid;
    }

    /**
     * @param int|null $uid
     */
    public function setUid(?int $uid): void
    {
        $this->uid = $uid;
    }

    /**
     * @return null
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param null $authKey
     */
    public function setAuthKey($authKey): void
    {
        $this->authKey = $authKey;
    }

    /**
     * @param array $extra
     * @return Parse
     */
    public function setExtra(array $extra): Parse
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * @return array
     */
    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

}