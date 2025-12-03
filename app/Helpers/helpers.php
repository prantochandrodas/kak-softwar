<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

// if (!function_exists('uploadImage')) {
//     function uploadImage(UploadedFile $file, $path,$prefix)
//     {
//         $folder = 'uploads/'.$path;
//         $filename = $prefix. '_' .time() . '.' . $file->getClientOriginalExtension();
//         $path = $file->storeAs($folder, $filename, 'public');
//         return $filename;
//     }
// }

if (!function_exists('uploadImage')) {
    function uploadImage(UploadedFile $file, $path, $prefix)
    {
        $folderPath = public_path('uploads/' . $path);

        // Create folder if not exists
        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true); // 0755 is safe
        }

        // Create a unique filename
        $filename = $prefix . '_' . time() . '_'  . uniqid()  . '.' . $file->getClientOriginalExtension();

        // Move uploaded file to the folder
        $file->move($folderPath, $filename);

        return $filename;
    }
}

if (!function_exists('check_permission')) {
    function check_permission($permission): bool
    {
        //        if (auth()->user()->user_role == 'super_admin' || auth()->user()->hasAnyPermission($permission)) {
        if (auth()->user()->hasAnyPermission($permission)) {
            return true;
        }
        return false;
    }
}

if (!function_exists('check_access')) {
    function check_access($permission)
    {
        //        if (auth()->user()->user_role != 'super_admin' && !auth()->user()->hasPermissionTo($permission)) {
        if (!auth()->user()->hasPermissionTo($permission)) {
            return false;
        }
        return true;
    }
}


function getBangladeshCurrency($number)
{
    // Getting decimal part
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen(floor($number));
    $i = 0;
    $str = [];

    // Word mapping for numbers
    $words = [
        0                   => '',
        1                   => 'One',
        2                   => 'Two',
        3                   => 'Three',
        4                   => 'Four',
        5                   => 'Five',
        6                   => 'Six',
        7                   => 'Seven',
        8                   => 'Eight',
        9                   => 'Nine',
        10                  => 'Ten',
        11                  => 'Eleven',
        12                  => 'Twelve',
        13                  => 'Thirteen',
        14                  => 'Fourteen',
        15                  => 'Fifteen',
        16                  => 'Sixteen',
        17                  => 'Seventeen',
        18                  => 'Eighteen',
        19                  => 'Nineteen',
        20                  => 'Twenty',
        30                  => 'Thirty',
        40                  => 'Forty',
        50                  => 'Fifty',
        60                  => 'Sixty',
        70                  => 'Seventy',
        80                  => 'Eighty',
        90                  => 'Ninety'
    ];

    $digits = ['', 'Hundred', 'Thousand', 'Lakh', 'Crore'];

    // Processing the number
    while ($i < $digits_length) {
        $divider = ($i == 2) ? 10 : 100;
        $number_part = $no % $divider;
        $no = floor($no / $divider);
        $i += ($divider == 10) ? 1 : 2;

        if ($number_part) {
            $counter = count($str);
            $plural = ($counter && $number_part > 9) ? '' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;

            // Check if $counter exceeds the size of $digits array
            $digit_word = isset($digits[$counter]) ? $digits[$counter] : ''; // Handle large numbers

            if ($number_part < 21) {
                // Handling numbers between 0 and 20
                $str[] = $words[$number_part] . ' ' . $digit_word . ' ' . $plural . $hundred;
            } else {
                // Handling numbers greater than 20
                $str[] = $words[floor($number_part / 10) * 10] . ' ' . $words[$number_part % 10] . ' ' . $digit_word . ' ' . $plural . $hundred;
            }
        } else {
            $str[] = null;
        }
    }

    // Constructing the Taka part
    $Taka = implode(' ', array_reverse($str));
    $Taka = preg_replace('/\s+/', ' ', trim($Taka)); // Clean up extra spaces

    // Handling decimal (poysa) part
    $poysa = ($decimal) ? " and " . $words[floor($decimal / 10)] . " " . $words[$decimal % 10] . ' Poysa' : '';

    // Returning full currency string
    return ($Taka ? $Taka . ' Taka' : '') . $poysa;
}

function convertNumberToWords($number)
{
    $words = array(
        0 => '',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Forty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety'
    );

    $digits = array(
        '',
        'Thousand',
        'Lakh',
        'Crore'
    );

    if ($number == 0) {
        return 'Zero';
    }

    $result = '';
    $place = 0;

    // Split the number into groups of 3 digits from right to left
    while ($number > 0) {
        $remainder = $number % 1000; // Get the last 3 digits
        $number = floor($number / 1000); // Remove last 3 digits

        if ($remainder > 0) {
            $result = convertThreeDigits($remainder, $words) . ' ' . $digits[$place] . ' ' . $result;
        }

        $place++;
    }

    return trim($result);
}

function convertThreeDigits($number, $words)
{
    $result = '';

    if ($number >= 100) {
        $hundreds = floor($number / 100);
        $result .= $words[$hundreds] . ' Hundred ';
        $number %= 100;
    }

    if ($number >= 20) {
        $tens = floor($number / 10) * 10;
        $result .= $words[$tens] . ' ';
        $number %= 10;
    }

    if ($number > 0) {
        $result .= $words[$number] . ' ';
    }

    return trim($result);
}