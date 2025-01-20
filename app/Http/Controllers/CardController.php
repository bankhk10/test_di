<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;
use App\Models\scanLogs;
use App\Models\shortLink;
use Illuminate\Support\Facades\Http;
use Stevebauman\Location\Location;
use Stevebauman\Location\Facades\Location as FacadesLocation;
use Carbon\Carbon;
use Nette\Utils\Json;

class CardController extends Controller
{

    public function getCard(Request $request, $id)
    {
        $ip = $this->getIp();
        $ip_address = $ip->ip ?? null;
        $user_scan_id = $request->cookie('key_id');
        $latitude = $request->cookie('latitude');
        $longitude = $request->cookie('longitude');
        $device_info = $request->cookie('device_info');
        $short_link = shortLink::where('code', $id)->first();
        $id = $short_link->create_by;

        // Log::info('user_id=' . $user_scan_id);
        // Log::info('id=' . $id);

        $scanLogs = new scanLogs();
        $scanLogs->scanned_id = $id;
        $scanLogs->scanner_id = $user_scan_id;
        $scanLogs->device_scan = $device_info;
        $scanLogs->ip_scan = $ip_address;
        $scanLogs->scan_location = $latitude . ',' . $longitude;
        $scanLogs->scanned_at = Carbon::now();

        $scanLogs->save();

        $client = new Client();
        $apiUrl = env('API_URL');
        $appUrl = env('APP_URL');
        $appHR = env('APP_HR');
        $apiToken = env('API_TOKEN');

        try {
            $response = $client->request('GET', $apiUrl . '/users/users.php', [
                'query' => ['user_id' => $id],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);
            $card = json_decode($response->getBody(), true);
            $imgCheck = optional(optional($card)['data'])['img_check'];
            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
            $fileExists = false;

            if ($remoteFile) {
                $ch = curl_init($remoteFile);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $fileExists = ($responseCode == 200);
            }

            $card['remoteFile'] = $remoteFile;
            $card['fileExists'] = $fileExists;

            $card['qr_code'] = base64_encode(QrCode::size(200)->generate("{$appUrl}/getCard/{$id}"));
            $card['img_profile'] = "{$appHR}/imageUser/employee/{$imgCheck}";
        } catch (\Exception $e) {
            $card = null;
        }

        if (!isset($card)) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        return response()->json($card, 200);
    }


    public function showCard($id)
    {

        Log::info("showCard");
        $client = new Client();
        $apiUrl = env('API_URL');
        $appUrl = env('APP_URL');
        $appHR = env('APP_HR');
        $apiToken = env('API_TOKEN');

        try {
            $response = $client->request('GET', $apiUrl . '/users/users.php', [
                'query' => ['user_id' => $id],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);
            $card = json_decode($response->getBody(), true);
            $imgCheck = optional(optional($card)['data'])['img_check'];
            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
            $fileExists = false;

            if ($remoteFile) {
                $ch = curl_init($remoteFile);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $fileExists = ($responseCode == 200);
            }

            $card['remoteFile'] = $remoteFile;
            $card['fileExists'] = $fileExists;

            $longUrl = "{$appUrl}/getCard/{$id}";
            $shortUrl = $this->shortenUrl($longUrl);
            $card['short_url'] = $shortUrl;


            // $card['qr_code'] = base64_encode(QrCode::size(200)->generate("{$appUrl}/getCard/{$id}"));
            $card['qr_code'] = base64_encode(QrCode::size(200)->generate($shortUrl));
            $card['img_profile'] = "{$appHR}/imageUser/employee/{$imgCheck}";
        } catch (\Exception $e) {
            $card = null;
        }

        if (!isset($card)) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        return response()->json($card, 200);
    }

    public function addContract($id)
    {
        Log::info("addContract");

        $client = new Client();
        $apiUrl = env('API_URL');
        $appUrl = env('APP_URL');
        $appHR = env('APP_HR');
        $apiToken = env('API_TOKEN');

        try {
            $response = $client->request('GET', $apiUrl . '/users/users.php', [
                'query' => ['user_id' => $id],
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiToken
                ]
            ]);
            $card = json_decode($response->getBody(), true);
            $imgCheck = optional(optional($card)['data'])['img_check'];
            $remoteFile = $imgCheck ? "{$appHR}/imageUser/employee/{$imgCheck}" : null;
            $fileExists = false;

            if ($remoteFile) {
                $ch = curl_init($remoteFile);
                curl_setopt($ch, CURLOPT_NOBODY, true);
                curl_exec($ch);
                $responseCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                curl_close($ch);

                $fileExists = ($responseCode == 200);
            }

            $card['remoteFile'] = $remoteFile;
            $card['fileExists'] = $fileExists;

            $card['img_profile'] = "{$appHR}/imageUser/employee/{$imgCheck}";
            $card['qr_code'] = base64_encode(QrCode::size(200)->generate("{$appUrl}/getCard/{$id}"));
        } catch (\Exception $e) {
            $card = null;
        }

        if (!isset($card)) {
            return response()->json(['error' => 'Card not found'], 404);
        }

        // อ่านไฟล์รูปภาพและแปลงเป็น base64
        $image = $fileExists ? $remoteFile : public_path('img/Logo-Vbeyond.png');
        $imageData = base64_encode(file_get_contents($image));
        $mimeType = mime_content_type($image);

        $card['name'] = optional(optional($card)['data'])['name_eng'];
        $card['phone'] = optional(optional($card)['data'])['phone'];
        $card['email'] = optional(optional($card)['data'])['email'];

        // สร้าง vCard
        $vcard = "BEGIN:VCARD\n";
        $vcard .= "VERSION:3.0\n";
        $vcard .= "FN:{$card['name']}\n";
        $vcard .= "TEL:{$card['phone']}\n";
        $vcard .= "EMAIL:{$card['email']}\n";
        $vcard .= "PHOTO;ENCODING=b;TYPE={$mimeType}:{$imageData}\n";
        $vcard .= "END:VCARD";

        return response($vcard, 200, [
            'Content-Type' => 'text/vcard',
            'Content-Disposition' => 'attachment; filename="contact.vcf"',
        ]);
    }

    public function generateEncrypted($id)
    {
        $shortLink = shortLink::where('create_by', $id)->first();
        if ($shortLink) {
            $link = $shortLink->code;
            $url = url("/getCard/{$link}");
            return response()->json([
                'url' => $url,
            ]);
        } else {
            $shortLink = new shortLink();
            $encryptedData = Crypt::encryptString($id);
            $shortUrl = substr($encryptedData, 10, 14);
            $shortLink->code = $shortUrl;
            $shortLink->encrypted = $encryptedData;
            $shortLink->create_by = $id;
            $shortLink->save();

            $url = url("/getCard/{$shortUrl}");
            return response()->json([
                'url' => $url,
            ]);
        }
    }


    public function deviceStore(Request $request)
    {

        Log::info("deviceStore");
        $data_device = $request->all();
        $short_link = shortLink::where('code', $data_device['user_id'])->first();
        $scan_logs = scanLogs::where('scanned_id', $short_link->create_by)->latest()->first();

        if ($scan_logs) {
            $scan_logs->device_scan = $data_device['device_info'] ?? null;
            $scan_logs->ip_scan = $data_device['ip_address'] ?? null;
            $scan_logs->scan_location = $data_device['latitude'] . ',' . $data_device['longitude'];
            $scan_logs->scanned_at = Carbon::now();
            $scan_logs->save();
        } else {
            return "No scan log found";
        }

        // session(['device_data' => $data]);
        // return response()->json(['message' => 'Data stored successfully!']);

        // return $request->all();

    }

    public function getIp()
    {
        $response = Http::get('https://api.ipify.org?format=json');
        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    }
}
