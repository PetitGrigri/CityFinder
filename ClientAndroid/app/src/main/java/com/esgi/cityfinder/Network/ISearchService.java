package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.Image.ImageResult;
import com.esgi.cityfinder.Model.SearchResult;

import java.util.List;
import java.util.Map;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface ISearchService {

    void search(String userToken, Map<String, Integer> searchMap, IServiceResultListener<List<SearchResult>> iServiceResultListener);

    void getImageUrl(String url, IServiceResultListener<List<ImageResult>> iServiceResultListener);

}
