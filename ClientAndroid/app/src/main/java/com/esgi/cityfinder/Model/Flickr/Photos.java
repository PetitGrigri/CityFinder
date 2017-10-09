package com.esgi.cityfinder.Model.Flickr;

import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Asif on 09/10/2017.
 */

public class Photos {

    @SerializedName("photo")
    private List<Photo> photoList = null;

    public List<Photo> getPhotoList() {
        return photoList;
    }
}
