<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;

//首页
// Route::any('/',function (){
//     return redirect('wiki');
// });




Route::group('v1',function (){
    Route::any('user/sendCode','demo/User/sendCode');
      Route::resource('user','demo/User');
});

Route::any('accessToken','demo/auth/accessToken');//Oauth



Route::get('task','command/Task/tasks');   


// 文档
// \DawnApi\route\DawnRoute::wiki();

// 接口地址
Route::group('api/v1',function() {
    // 游戏
    // 获取游戏资讯类型
    Route::get('getGamesType','api/v1.infomation/getGamesType');
    // 获取游戏资讯
    Route::get('getGamesList','api/v1.infomation/getGamesList');
    // 获取游戏资讯的轮播图
    Route::get('getGamesCarousel','api/v1.infomation/getGamesCarousel');
    // 获取游戏资讯的推荐
    Route::get('getGamesRecommend','api/v1.infomation/getGamesRecommend');
    // 获取采集游戏资讯 
    Route::get('getGatherInformation','api/v1.infomation/getGatherInformation');
    // 获取游戏资讯详情
    Route::get('getGamesArticleToId','api/v1.infomation/getGamesArticleToId');
    
    // 采集游戏资讯 
    Route::get('gatherGameInformation','api/v1.gather/gatherGameInformation');
    
    // 体育
    // 获取体育资讯类型
    Route::get('getSportsType','api/v1.infomation/getSportsType');
    // 获取体育资讯
    Route::get('getSportsList','api/v1.infomation/getSportsList');
    // 获取体育资讯的轮播图
    Route::get('getSportsCarousel','api/v1.infomation/getSportsCarousel');
    // 获取体育资讯的推荐
    Route::get('getSportsRecommend','api/v1.infomation/getSportsRecommend');
    // 获取体育资讯详情
    Route::get('getSportsArticleToId','api/v1.infomation/getSportsArticleToId');
    
    // 电影
    // 获取电影资讯类型
    Route::get('getMoviesType','api/v1.infomation/getMoviesType');
    // 获取电影资讯
    Route::get('getMoviesList','api/v1.infomation/getMoviesList');
    // 获取电影资讯的轮播图
    Route::get('getMoviesCarousel','api/v1.infomation/getMoviesCarousel');
    // 获取电影资讯的推荐
    Route::get('getMoviesRecommend','api/v1.infomation/getMoviesRecommend');
    // 获取电影资讯详情
    Route::get('getMoviesArticleToId','api/v1.infomation/getMoviesArticleToId');
});



return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    
];


