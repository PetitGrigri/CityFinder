package com.esgi.cityfinder.Model.Image;

import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Asifadam93 on 09/10/2017.
 */

public class Items {

    @SerializedName("pagemap")
    private PageMap pageMap;

    @SerializedName("title")
    private String title;

    public PageMap getPageMap() {
        return pageMap;
    }

    public String getTitle() {
        return title;
    }
}
