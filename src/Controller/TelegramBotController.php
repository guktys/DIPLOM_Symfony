<?php

namespace App\Controller;

use App\Entity\Appointment;
use App\Entity\User;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TelegramBotController extends AbstractController
{
//https://api.telegram.org/bot7032467161:AAGVsDOn5UQ4i-jS8ZI5LMXZWHDizsP6htE/getUpdates
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }


    #[Route("/get-telegram-updates", name: "get_telegram_updates")]
    public function getUpdates(Request $request): Response
    {
        $token = $this->getParameter('telegram_http_api_token');
        $uri = 'https://api.telegram.org/bot' . $token;
        $uriGetUpdates = $uri . '/getUpdates';
        $uriSendMessage = $uri . '/sendMessage?';
        try {
            $response = $this->client->request('GET', $uriGetUpdates);
            $data = json_decode($response->getBody()->getContents(), true);
            $last = array_key_last($data['result']);
            $chatId = $data['result'][$last]['message']['chat']['id'];
            $userId = $data['result'][$last]['message']['from']['id'];
            $getQuery = array(
                "chat_id" => $chatId,
                "text" => "<b>User ID: </b>" . $userId,
                "parse_mode" => "html",);
            $sendMessage = $this->client->request('GET', $uriSendMessage . http_build_query($getQuery));
            return new Response(json_encode($sendMessage));
        } catch (\Exception $e) {
            return new Response("Error: " . $e->getMessage());
        }
    }

    public function sendAppointmentMessage(Appointment $appointment, User $user, User $master): Response
    {
        $token = $this->getParameter('telegram_http_api_token');
        $uri = 'https://api.telegram.org/bot' . $token;
        $uriSendMessage = $uri . '/sendMessage?';
        try {
            $getQuery = array(
                "chat_id" => $user->getUserDetails()->getTelegram(),
                "text" => "<b>Привіт, ви записалися на процедуру!</b> \n <b> Процедура: </b>" . $appointment->getService()->getName() . " \n <b>Час:</b> " . $appointment->getTime()->format('Y-m-d H:i:s') . " \n",
                "parse_mode" => "html",);
            $sendMessage = $this->client->request('GET', $uriSendMessage . http_build_query($getQuery));

            $getQueryMaster = array(
                "chat_id" => $master->getUserDetails()->getTelegram(),
                "text" => "<b>Привіт, до вас записалися на процедуру!</b> \n <b> Процедура: </b>" . $appointment->getService()->getName() .
                    " \n <b>Час:</b> " . $appointment->getTime()->format('Y-m-d H:i:s') . " \n <b> Клієнт:</b> " .
                    $master->getFirstname() . " " . $master->getLastname() . " \n <b>Телефон клієнта:</b> " . $user->getPhone(),
                "parse_mode" => "html",);
            $sendMessage = $this->client->request('GET', $uriSendMessage . http_build_query($getQueryMaster));
            return new Response(json_encode($sendMessage));
        } catch (\Exception $e) {
            return new Response("Error: " . $e->getMessage());
        }
    }

    public function sendRegisterMessage(User $user, $chatId)
    {
        $token = $this->getParameter('telegram_http_api_token');
        $uri = 'https://api.telegram.org/bot' . $token;
        $uriSendMessage = $uri . '/sendMessage?';
        try {
            $getQuery = array(
                "chat_id" => $chatId,
                "text" => "<b>Привіт," . $user->getFirstname() . " ви  успішно зареєстровані!</b> \n",
                "parse_mode" => "html",);
            $sendMessage = $this->client->request('GET', $uriSendMessage . http_build_query($getQuery));

        } catch (\Exception $e) {
        }
    }

    #[Route("/waiting_telegram_chat_id", name: "waiting_telegram_chat_id")]
    public function waitingUserChatId(Request $request)
    {
        $client = new Client();
        $token = $this->getParameter('telegram_http_api_token');
        $uri = 'https://api.telegram.org/bot' . $token;
        $uriGetUpdates = $uri . '/getUpdates';
        $interval = 1;
        $duration = 360;
        $userName = $request->get('userName');
        $endTime = time() + $duration;

        while (time() < $endTime) {
            try {
                $response = $this->client->request('GET', $uriGetUpdates);
                $data = json_decode($response->getBody()->getContents(), true);
                $last = array_key_last($data['result']);
                $userNameFromChat = $data['result'][$last]['message']['from']['username'];
                if ($userNameFromChat == $userName) {
                    $uriSendMessage = $uri . '/sendMessage?';
                    try {
                        $getQuery = array(
                            "chat_id" => $data['result'][$last]['message']['chat']['id'],
                            "text" => "<b>Привіт," . $userNameFromChat . " ваш чат айди успішно встановлено тепер ми можено вам надсилати повідомлення!</b> \n",
                            "parse_mode" => "html",);
                        $this->client->request('GET', $uriSendMessage . http_build_query($getQuery));

                    } catch (\Exception $e) {
                    }
                    return new Response($data['result'][$last]['message']['chat']['id']);
                }
            } catch (RequestException $e) {
                return new Response("HTTP Request failed: " . $e->getMessage() . "\n");
            }

            sleep($interval);
        }
    }

}