package com.esgi.cityfinder.Model.Image;

import com.google.gson.annotations.SerializedName;

/**
 * Created by Asifadam93 on 09/10/2017.
 */

public class PageMap {

    @SerializedName("cse_image")
    private CseImage cseImage;

    public CseImage getCseImage() {
        return cseImage;
    }

}
