package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.Auth;
import com.esgi.cityfinder.Model.User;
import com.esgi.cityfinder.Network.Services.IRetrofitAuthService;
import com.esgi.cityfinder.Network.Services.IRetrofitUserService;

import java.util.Map;

import retrofit2.Call;
import retrofit2.Callback;
import retrofit2.Response;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class RetrofitUserService implements IUserService {

    private IRetrofitUserService retrofitUserService;

    private IRetrofitUserService getRetrofitUserService(){
        if(retrofitUserService == null){
            retrofitUserService = RetrofitSession.getInstance().create(IRetrofitUserService.class);
        }
        return retrofitUserService;
    }

    @Override
    public void register(Map<String, String> registerUserMap, final IServiceResultListener<User> iServiceResultListener) {
        getRetrofitUserService().registerUser(registerUserMap).enqueue(new Callback<User>() {
            @Override
            public void onResponse(Call<User> call, Response<User> response) {
                ServiceResult<User> result = new ServiceResult<>();

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
            public void onFailure(Call<User> call, Throwable t) {
                if(iServiceResultListener != null){
                    iServiceResultListener.onResult(new ServiceResult<User>(t.getMessage()));
                }
            }
        });
    }
}
