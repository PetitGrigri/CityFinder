package com.esgi.cityfinder.Network;

import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.util.Log;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.DetailSearch;
import com.esgi.cityfinder.Model.Flickr.FlickrImage;
import com.esgi.cityfinder.Model.Flickr.Photo;
import com.esgi.cityfinder.Model.Flickr.Photos;
import com.esgi.cityfinder.Model.Image.ImageResult;
import com.esgi.cityfinder.Model.Image.Items;
import com.esgi.cityfinder.Model.SearchResult;
import com.esgi.cityfinder.Model.User;
import com.esgi.cityfinder.Network.Services.IRetrofitSearchService;

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
    public void getImageUrl(String url, final IServiceResultListener<Photo> iServiceResultListener) {

        getRetrofitSearchService().getImageUrl(url).enqueue(new Callback<FlickrImage>() {
            @Override
            public void onResponse(Call<FlickrImage> call, Response<FlickrImage> response) {

                ServiceResult<Photo> result = new ServiceResult<>();

                if (response.isSuccessful()) {

                    Photo mPhoto = response.body().getPhotos().getPhotoList().get(0);

                    if (mPhoto != null) {
                        result.setData(mPhoto);
                    } else {
                        result.setErrorMsg("Error json");
                    }

                } else {
                    result.setErrorMsg("Erreur de connexion : " + response.code());
                }

                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(result);
                }
            }

            @Override
            public void onFailure(Call<FlickrImage> call, Throwable t) {
                Log.i("getImageUrl", "Response : " + t.getMessage());

                if (iServiceResultListener != null) {
                    iServiceResultListener.onResult(new ServiceResult<Photo>(t.getMessage()));
                }

            }
        });
    }

    @Override
    public void getBitmapImage(String url, final IServiceResultListener<Bitmap> iServiceResultListener) {

        getRetrofitSearchService().getBitmapImage(url).enqueue(new Callback<ResponseBody>() {
            @Override
            public void onResponse(Call<ResponseBody> call, Response<ResponseBody> response) {

                ServiceResult<Bitmap> result = new ServiceResult<>();

                if (response.isSuccessful()) {

                    Bitmap bitmapImage = null;
                    try {
                        bitmapImage = BitmapFactory.decodeStream(response.body().byteStream());
                        result.setData(bitmapImage);
                    } catch (Exception e) {
                        result.setErrorMsg("Error bitmap");
                    }

                    if (iServiceResultListener != null) {
                        iServiceResultListener.onResult(result);
                    }
                }

            }

            @Override
            public void onFailure(Call<ResponseBody> call, Throwable t) {

            }
        });

    }
}
