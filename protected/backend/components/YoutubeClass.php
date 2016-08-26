<?php

#####################################
#
# Name: Youtube Video Fetcher
# Filename: ytf.class.php
# Autor: Biagio Vincenzo Mamone Neto
# Contact: contato@bmamone.com
# Autor Homepage: http://www.bmamone.com
# Version: 1.0
#
# License: FREE FOR NON COMERCIAL USE
#
#####################################

namespace backend\components;

class YoutubeClass {

    public static $info_url = 'http://youtube.com/get_video_info?video_id='; // dont change it
    public static $video_files_path = '/uploads/videos/'; // dont forget the slash in the end

    # getInfoFile
    # gets the information file needed to retrieve the video download url

    private static function getInfoFile($id) {
        $info_file = @file_get_contents('http://youtube.com/get_video_info?video_id=' . $id);
     
        parse_str($info_file, $psd);
        if (!empty($psd['url_encoded_fmt_stream_map'])) {
            return $psd;
        } else {

            die('Error 001: Could not get video information file');
        }
    }

    # getUrl
    # get the url for the video quality specified, if 999, gets the best one, if 0, the worst. If it could not find the quality specified, it returns a error.

    private static function getUrl($id, $SPECquality) {

        $info_file = static::getInfoFile($id);
        $url_map = $info_file['url_encoded_fmt_stream_map'];

        if ($SPECquality == 999) {

            # best quality

            $urls = explode('|', $url_map);
            if (count($urls) > 2) {
                $best_quality = substr($urls[1], 0, -3);
            } else {
                $best_quality = $urls[1];
            }
            return $best_quality;
        } else if ($SPECquality == 0) {
            # worst quality

            $urls = explode('|', $url_map);
            $worst_quality = $urls[count($urls) - 1];
            return $worst_quality;
        } else {
            # quality is specified

            $urls_with_quality = explode(',', $url_map);

            $final_url_array = array();

            foreach ($urls_with_quality as $url_with_quality) {
       
                $final_url_array[5] = $url_with_quality;
            }

            if (@!$final_url_array[$SPECquality]) {

                die('Error 004: the specified (' . $SPECquality . ') quality does not exist');
            } else {

                return $final_url_array[$SPECquality];
            }
        }
    }

    # getVideo
    # downloads the video and returns it

    private function getVideo($id, $quality) {

        return file_get_contents(static::getUrl($id, $quality));
    }

    # getVideoToFile
    # puts the downloaded video into a file in the specified path

    private static function getVideoToFile($id, $quality) {
        $file_path = '../uploads/videos/' . $id . '.mp4';
        $handle = fopen($file_path, 'w');
                var_dump(static::getVideo($id, $quality)); exit;
//        if (fwrite($handle, static::getVideo($id, $quality))) {
//
//            fclose($handle);
//            return $file_path;
//        } else {
//
//            fclose($handle);
//            die('Error 003: failed to write the video file');
//        }
    }

    # downloadVideo
    # just executes the whole script, this function is the one wich has to be called

    public static function download($id, $quality = '999') {
        if (static::getVideoToFile($id, $quality)) {
            return true;
        } else {
            return false;
        }
    }

}
