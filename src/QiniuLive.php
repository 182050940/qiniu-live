<?php
/**
 * Created by PhpStorm.
 * User: Array
 * Date: 2018/6/26
 * Time: 下午5:50
 */

namespace Laoliu\Qiniu\Live;

use Qiniu\Pili\Mac;
use Qiniu\Pili\Hub;
use Qiniu\Pili\Stream;
use function Qiniu\Pili\HDLPlayURL;
use function Qiniu\Pili\HLSPlayURL;
use function Qiniu\Pili\RTMPPlayURL;
use function Qiniu\Pili\RTMPPublishURL;
use function Qiniu\Pili\SnapshotPlayURL;

use Illuminate\Support\Collection;

class QiniuLive
{

    private $mac;
    private $hub;

    /**
     * QiniuLive constructor.
     */
    public function __construct($accesskey = null, $secretkey = null, $hubname = null)
    {
        $this->mac = new Mac($accesskey, $secretkey);
        $this->hub = new Hub($this->mac, $hubname);
    }

    /**
     * 创建流
     *
     * @param $streamKey
     * @return \Exception|Stream
     */
    public function create($streamKey)
    {
        try {
            $res = $this->hub->create($streamKey);
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }


    /**
     * 获取流信息
     *
     * @param $streamKey
     * @return array|\Exception
     */

    public function info($streamKey)
    {
        try {
            $res = $this->hub->stream($streamKey)->info();
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }


    /**
     * 获取全部流
     * @param null $streamKey
     * @return array|\Exception|mixed|null
     */
    public function listStreams($streamKey = null)
    {
        try {
            $res = $this->hub->listStreams($streamKey, 1, '');
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }


    /**
     * 获取全部流
     * @param null $streamKey
     * @return array|\Exception|mixed|null
     */
    public function batchLiveStatus($streamKey = null)
    {
        try {
            $res = $this->hub->batchLiveStatus($streamKey);
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }

    /**
     * 获取直播中的流
     * @param null $streamKey
     * @return array|\Exception|mixed|null
     */
    public function listLiveStreams($streamKey = null)
    {
        try {
            $res = $this->hub->listLiveStreams($streamKey, 1, '');
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }

    /**
     * 允许推流
     * @return null
     */
    public function enable($streamKey)
    {
        try {
            $res = $this->hub->stream($streamKey)->enable();
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }

    /**
     * 禁止推流
     * @return null
     */
    public function disable($streamKey)
    {
        try {
            $res = $this->hub->stream($streamKey)->disable();
        } catch (\Exception $exception) {
            return $exception;
        }
        return $res;
    }

    /**
     * 获取直播流状态
     * @return bool
     */
    public function liveStatus($streamKey)
    {
        try {
            $status = $this->hub->stream($streamKey)->liveStatus();
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }

    /**
     * 直播流录制
     * @return bool
     */
//    public function save($streamKey)
//    {
//        try {
//            $status = $this->hub->stream($streamKey)->save(0, 0);
//        } catch (\Exception $e) {
//            $status = false;
//        }
//
//        return $status;
//    }

    /**
     * 高级直播流录制
     * @return bool
     */
    public function saveAs($streamKey, $option = [])
    {
        try {
            $status = $this->hub->stream($streamKey)->saveas($option);
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }

    /**
     * 查询直播历史
     * @return bool
     */
    public function historyActivity($streamKey)
    {
        try {
            $status = $this->hub->stream($streamKey)->historyActivity(0, 0);
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }

    /**
     * 获取推流地址
     * @param $streamKey
     * @return string
     */
    public function PushUrl($streamKey)
    {
        return RTMPPublishURL(
            config('home77.live.pushurl'),
            config('home77.live.hubname'),
            $streamKey,
            config('home77.live.expiretime'),
            config('home77.live.accesskey'),
            config('home77.live.secretkey')
        );
    }

    /**
     * 获取播放地址
     * @param $streamKey
     * @return Collection
     */
    public function PlayUrl($streamKey)
    {
        $play_url = new Collection();
        $play_url->rtmp = RTMPPlayURL(config('home77.live.pullurl.rtmp'), config('home77.live.hubname'), $streamKey);
        $play_url->hls = HLSPlayURL(config('home77.live.pullurl.hls'), config('home77.live.hubname'), $streamKey);
        $play_url->hdl = HDLPlayURL(config('home77.live.pullurl.hdl'), config('home77.live.hubname'), $streamKey);
        $play_url->snapshot = SnapshotPlayURL(config('home77.live.snapshoturl'), config('home77.live.hubname'), $streamKey);
        return $play_url;
    }

    /**
     * 转码设置
     * @param $streamKey
     * @return Collection
     */
    public function convert($streamKey, $profiles)
    {
        try {
            $status = $this->hub->stream($streamKey)->updateConverts($profiles);
        } catch (\Exception $e) {
            $status = false;
        }

        return $status;
    }
}

