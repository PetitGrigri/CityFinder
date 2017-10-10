package com.esgi.cityfinder.Network;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Log;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.DetailSearch;
import com.esgi.cityfinder.Model.Flickr.FlickrImage;
import com.esgi.cityfinder.Model.Flickr.Photo;
import com.esgi.cityfinder.Model.Flickr.Photos;
import com.esgi.cityfinder.Model.Image;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Model.User;
import com.esgi.cityfinder.Network.Services.IRetrofitSearchService;

import java.io.IOException;
import java.util.List;
import java.util.Map;

import okhttp3.ResponseBody;
import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class RetrofitSearchService implements ISearchService {

    private IRetrofitSearchService retrofitSearchService;

    private IRetrofitSearchService getRetrofitSearchService() {
        if (retrofitSearchService == null) {
            retrofitSearchService = RetrofitSession.getInstance().create(IRetrofitSearchService.class);
        }
        return retrofitSearchService;
    }


    @Override
    public void search(String userToken, Map<String, Integer> searchMap, final IServiceResultListener<List<SearchResult>> iServiceResultListener) {

        getRetrofitSearchService().search(userToken, searchMap).enqueue(new Callback<List<SearchResult>>() {
            @Override
            public void onResponse(Call<List<SearchResult>> call, Response<List<SearchResult>> response) {

                ServiceResult<List<SearchResult>> result = new ServiceResult<List<SearchResult>>();

                if (response.isSuccessful()) {
                    result.setData(response.body());
                } else {
                    result.setErrorMsg("Erreur de connexion : " + response.code());
                }

                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(result);
                }

            }

            @Override
            public void onFailure(Call<List<SearchResult>> call, Throwable t) {
                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(new ServiceResult<List<SearchResult>>(t.getMessage()));
                }
            }
        });

    }

    @Override
    public void detailSearch(String userToken, Integer idCity, final IServiceResultListener<DetailSearch> iServiceResultListener) {

        getRetrofitSearchService().detailSearch(userToken, idCity).enqueue(new Callback<DetailSearch>() {
            @Override
            public void onResponse(Call<DetailSearch> call, Response<DetailSearch> response) {

                ServiceResult<DetailSearch> result = new ServiceResult<>();

                if (response.isSuccessful()) {
                    DetailSearch detailSearch = response.body();

                    Log.i("SearchService","Search : "+detailSearch.toString());

                    result.setData(detailSearch);
                } else {
                    result.setErrorMsg("Erreur connecxion");
                }

                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(result);
                }

            }

            @Override
            public void onFailure(Call<DetailSearch> call, Throwable t) {
                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(new ServiceResult<DetailSearch>(t.getMessage()));
                }
            }
        });
    }

    @Override
    public void getImageUrl(String userToken, Integer idCity, final IServiceResultListener<Image> iServiceResultListener) {

        ServiceResult<Image> result = new ServiceResult<>();

        try {
            Image mImage = getRetrofitSearchService().getImageUrl(userToken, idCity).execute().body();

            if(mImage != null){
                result.setData(mImage);
            } else {
                result.setErrorMsg("Error image");
            }

        } catch (IOException e) {
            e.printStackTrace();
        }


       /* getRetrofitSearchService().getImageUrl(userToken, idCity).enqueue(new Callback<Image>() {
            @Override
            public void onResponse(Call<Image> call, Response<Image> response) {

                ServiceResult<Image> result = new ServiceResult<Image>();

                if(response.isSuccessful()){

                    Image image = response.body();
                    result.setData(image);
                } else {!
                    result.setErrorMsg("Connexion error");
                }


                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(result);
                }

            }

            @Override
            public void onFailure(Call<Image> call, Throwable t) {
                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(new ServiceResult<Image>(t.getMessage()));
                }
            }
        });*/
    }
}