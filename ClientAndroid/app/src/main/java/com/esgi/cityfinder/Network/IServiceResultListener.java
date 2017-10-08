package com.esgi.cityfinder.Network;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IServiceResultListener<T> {
    void onResult(ServiceResult<T> result);
}
