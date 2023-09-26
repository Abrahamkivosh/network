<?php

function getPaymentStatus($status)
{
    switch ($status) {
        case '0':
            return "<span class='badge bg-warning'>Pending</span>";
            break;
        case '1':
            return "<span class='badge bg-success'>Paid</span>";
            break;
        case '2':
            return "<span class='badge bg-danger'>Failed</span>";
            break;
        case '3':
            return "<span class='badge bg-info'>Cancelled</span>";
            break;
        case '4':
            return "<span class='badge bg-info'>Refunded</span>";
            break;
        case '5':
            return "<span class='badge bg-info'>Partially Refunded</span>";
            break;

        default:
            return "<span class='badge bg-warning'>N/A</span>";
            break;
    }
}

function createReferenceNumber($length = 10)
{
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    // today number of day of the month
    $month = date('j');
    // currentYear short version
    $year = date('y');
    // today hour
    $hour = date('H');
    // today minute
    $minute = date('i');
    // today second
    $second = date('s');

    $randomString = '';
    $randomString .= $characters[rand(0, strlen($characters) - 1)];
    $randomString .= $month;
    $randomString .= $year;
    $randomString .= $hour;
    $randomString .= $minute;
    $randomString .= $second;

    return $randomString;

}
