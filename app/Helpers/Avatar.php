<?php

/**
 * Return image Url.
 *
 * @param Model instance, MediaCollection Name, if thumb pass
 * @return String
 */
function getAvatarUrl($modelName, $mediaCollectionName, $thumb = null){

    // if avatar upload then return upload image
    if ($modelName->getMedia($mediaCollectionName)->first()) {

        if ($thumb) {
            return $modelName->getFirstMediaUrl($mediaCollectionName, $thumb);
        } else {
            return $modelName->getFirstMediaUrl($mediaCollectionName);
        }
    }

    // Image not upload then return default image
    return asset('images/avatar.png');
}
