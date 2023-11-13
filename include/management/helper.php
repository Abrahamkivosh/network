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

function encryptId($id)
{
    $key = "1234567890";
    $id = base64_encode($id);
    $id = strrev($id);
    $id = $id . $key;
    $id = base64_encode($id);
    return $id;
}

function decryptId($id)
{
    $key = "1234567890";
    $id = base64_decode($id);
    $id = substr($id, 0, -10);
    $id = base64_decode(strrev($id));
    return $id;
}

function getInvoiceStatus($status)
{
    switch ($status) {
        case 'open':
            return "<span class='badge bg-warning'>OPEN</span>";
            break;
        case 'paid':
            return "<span class='badge bg-success'>PAID</span>";
            break;
        case 'disputed':
            return "<span class='badge bg-danger'>DISPUTED</span>";
            break;
        case 'draft':
            return "<span class='badge bg-info'>DRAFT</span>";
            break;
        case 'sent':
            return "<span class='badge bg-info'>SENT</span>";
            break;
        case 'partial':
            return "<span class='badge bg-info'>PARTIAL</span>";
            break;
        default:
            return "<span class='badge bg-warning'>N/A</span>";
            break;
        }
}