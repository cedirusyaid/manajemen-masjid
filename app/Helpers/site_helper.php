<?php

if (!function_exists('site_name')) {
    /**
     * Dapatkan nama website/masjid secara terpusat
     */
    function site_name(): string
    {
        return config('App')->siteName ?? 'Website Resmi Masjid';
    }
}

if (!function_exists('site_address')) {
    /**
     * Dapatkan alamat fisik resmi masjid secara terpusat
     */
    function site_address(): string
    {
        return config('App')->siteAddress ?? 'Alamat Resmi Masjid Anda';
    }
}

if (!function_exists('donation_bsi_number')) {
    function donation_bsi_number(): string
    {
        return config('App')->donationBsiNumber ?? '0000000000';
    }
}

if (!function_exists('donation_bsi_holder')) {
    function donation_bsi_holder(): string
    {
        return config('App')->donationBsiHolder ?? 'Kas Bendahara Masjid';
    }
}

if (!function_exists('donation_sulselbar_number')) {
    function donation_sulselbar_number(): string
    {
        return config('App')->donationSulselbarNumber ?? '0000000000000';
    }
}

if (!function_exists('donation_sulselbar_holder')) {
    function donation_sulselbar_holder(): string
    {
        return config('App')->donationSulselbarHolder ?? 'Panitia Pembangunan Masjid';
    }
}

if (!function_exists('qris_data')) {
    function qris_data(): string
    {
        return config('App')->qrisData ?? 'MasjidAndaInfaqDigital';
    }
}

if (!function_exists('qris_url')) {
    function qris_url(int $size = 250): string
    {
        $payload = qris_data();
        return "https://api.qrserver.com/v1/create-qr-code/?size={$size}x{$size}&data=" . urlencode($payload);
    }
}

if (!function_exists('contact_email')) {
    /**
     * Dapatkan email kontak resmi terpusat
     */
    function contact_email(): string
    {
        return config('App')->contactEmail ?? 'info@masjidanda.or.id';
    }
}

if (!function_exists('contact_phone')) {
    /**
     * Dapatkan telepon kontak resmi terpusat
     */
    function contact_phone(): string
    {
        return config('App')->contactPhone ?? '(021) 12345678';
    }
}
