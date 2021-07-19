<?php

namespace App\SaidTech\Traits\Data;

trait avatarsTrait
{

    public function getAvatars() {
        $list_avatars = [];

        for ($i = 1; $i <= 26; $i++){
            if (in_array($i, [ 4,7,9, 19,21,23 ])) {
                continue;
            }

            $list_avatars[$i] = collect([
                'id' => $i,
                'uri' => $i . '.png'
            ]);
        };

        return collect($list_avatars);
    }
}
