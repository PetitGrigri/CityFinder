package com.esgi.cityfinder.Model.Image;

import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Asifadam93 on 09/10/2017.
 */

public class ImageResult {

    @SerializedName("items")
    private List<Items> itemsList;

    @SerializedName("kind")
    private String kind;

    public List<Items> getItemsList() {
        return itemsList;
    }

    public String getKind() {
        return kind;
    }
}
