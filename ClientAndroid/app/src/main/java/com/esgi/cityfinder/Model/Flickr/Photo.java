package com.esgi.cityfinder.Model.Flickr;

/**
 * Created by Asif on 09/10/2017.
 */

public class Photo {

    private long id;
    private String secret;
    private Integer server;
    private Integer farm;

    public long getId() {
        return id;
    }

    public String getSecret() {
        return secret;
    }

    public Integer getServer() {
        return server;
    }

    public Integer getFarm() {
        return farm;
    }
}
