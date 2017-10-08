package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.Auth;

import java.util.Map;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IAuthService {

    void authentication(Map<String, String> userMap, IServiceResultListener<Auth> iServiceResultListener);

}
