<?php

use App\Models\User;

/**
 * Calculate percentage of profile is completed
 *
 * @param $profile
 * @return float|int
 */
function calculate_profile($profile)
{
    if (!$profile)
    {
        return 0;
    }

    $columns        = preg_grep('/(.+ed_at)|(.*id)|(.*_type)|(is_*)/',array_keys($profile->toArray()),PREG_GREP_INVERT);
    $delete_columns = ["slug","units","average_rate","public_activation","secret_code","seo_title","meta_description","meta_keywords","settings","device_ip_address","role","roles"];

    $columns = \array_diff($columns,$delete_columns);

    $per_column = 100 / count($columns);
    $total      = 0;

    foreach ($profile->toArray() as $key => $value)
    {
        //check column if not null or empty
        if ($value !== null && $value !== [] && in_array($key,$columns) && $value !== '')
        {
            $total += $per_column;
        } else
        {
            $emp[] = $key;
        }
    }

    return $total;
}


if (!function_exists('make_slug'))
{
    function make_slug($string,$separator = '-')
    {
        $string = trim($string);
        $string = mb_strtolower($string,'UTF-8');

        // Make alphanumeric (removes all other characters)
        // this makes the string safe especially when used as a part of a URL
        // this keeps latin characters and Persian characters as well
        $string = preg_replace("/[^a-z0-9_\s-]+ةءأاآؤئبپتثجچحخدذرزژإسشصضطظعغفقکگلمنيكوهی]/u",'',$string);

        // Remove multiple dashes or whitespaces or underscores
        // $string = preg_replace("/[\s-_]+/", ' ', $string);

        // Convert whitespaces and underscore to the given separator
        $string = preg_replace("/[\s_]/",$separator,$string);

        return $string;
    }
}

if (!function_exists('check_user_type'))
{
    /**
     * @param array $types
     * @return bool
     * @throws AuthorizationException
     */
    function check_user_type($types = [])
    {
        foreach ($types as $type)
        {
            if (Auth::user()->user_type == $type)
            {
                return true;
            }
        }

        return false;
    }
}
