package com.esgi.cityfinder.Model;

import com.google.gson.annotations.SerializedName;

/**
 * Created by Asif on 10/10/2017.
 */

public class Image {

    @SerializedName("url_wikipedia")
    private String url;

    public String getUrl() {
        return url;
    }
}
