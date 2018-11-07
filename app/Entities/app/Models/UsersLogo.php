<?php

namespace app\Models;

/**
 * UsersLogo
 */
class UsersLogo
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var \App\Models\Users
     */
    private $user;


    /**
     * Set path
     *
     * @param string $path
     *
     * @return UsersLogo
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set user
     *
     * @param \App\Models\Users $user
     *
     * @return UsersLogo
     */
    public function setUser(\App\Models\Users $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \App\Models\Users
     */
    public function getUser()
    {
        return $this->user;
    }
}

