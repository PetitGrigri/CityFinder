package com.esgi.cityfinder.Network;

import com.esgi.cityfinder.Model.User;

import java.util.Map;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public interface IUserService {

    void register(Map<String,String> registerUserMap, IServiceResultListener<User> iServiceResultListener);


}
