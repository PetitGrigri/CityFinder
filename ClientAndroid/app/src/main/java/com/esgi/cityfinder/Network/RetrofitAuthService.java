package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Network.Services.IRetrofitAuthService;

import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class RetrofitAuthService implements IAuthService {

    private IRetrofitAuthService retrofitAuthService;

    private IRetrofitAuthService getRetrofitAuthService(){
        if(retrofitAuthService == null){
            retrofitAuthService = RetrofitSession.getInstance().create(IRetrofitAuthService.class);
        }
        return retrofitAuthService;
    }

    @Override
    public void authentication(Map<String, String> userMap, final IServiceResultListener<Auth> iServiceResultListener) {

        getRetrofitAuthService().authentication(userMap).enqueue(new Callback<Auth>() {
            @Override
            public void onResponse(Call<Auth> call, Response<Auth> response) {

                ServiceResult<Auth> result = new ServiceResult<>();

                if(response.isSuccessful()){
                    result.setData(response.body());
                } else {
                    result.setErrorMsg("Erreur de connexion : "+response.code());
                }

                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(result);
                }
            }

            @Override
            public void onFailure(Call<Auth> call, Throwable t) {

                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(new ServiceResult<Auth>(t.getMessage()));
                }
            }
        });

    }

}
