package com.esgi.cityfinder.Model;

/**
 * Created by Asifadam93 on 07/10/2017.
 */

public class City {

    private String name;
    private String detail;
    private int photoId;

    public City(String name, String detail ,int photoId) {
        this.name = name;
        this.photoId = photoId;
        this.detail = detail;
    }

    public String getName() {
        return name;
    }

    public String getDetail() {
        return detail;
    }

    public int getPhotoId() {
        return photoId;
    }
}
