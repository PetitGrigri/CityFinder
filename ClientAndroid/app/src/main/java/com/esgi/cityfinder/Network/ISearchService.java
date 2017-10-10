package com.esgi.cityfinder.Network;

import android.graphics.Bitmap;

import com.esgi.cityfinder.Model.DetailSearch;
import com.esgi.cityfinder.Model.Flickr.FlickrImage;
import com.esgi.cityfinder.Model.Flickr.Photo;
import com.esgi.cityfinder.Model.Flickr.Photos;
import com.esgi.cityfinder.Model.Image;
import com.esgi.cityfinder.Model.SearchResult;

import java.util.List;
import java.util.Map;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface ISearchService {

    void search(String userToken, Map<String, Integer> searchMap, IServiceResultListener<List<SearchResult>> iServiceResultListener);

    void detailSearch(String userToken, Integer idCity, IServiceResultListener<DetailSearch> iServiceResultListener);

    void getImageUrl(String userToken,String cityName, IServiceResultListener<Image> iServiceResultListener);

}
