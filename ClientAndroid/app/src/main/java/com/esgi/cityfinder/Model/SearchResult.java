package com.esgi.cityfinder.Model;

import com.google.gson.annotations.SerializedName;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class SearchResult {

    private Integer id;

    @SerializedName("nomDepartement")
    private String departementName;

    @SerializedName("nomRegion")
    private String regionName;

    @SerializedName("name")
    private String cityName;

    @SerializedName("codeRegion")
    private Integer regionCode;

    @SerializedName("codeDepartement")
    private String departementCode;

    private String href;

    public Integer getId() {
        return id;
    }

    public String getDepartementName() {
        return departementName;
    }

    public String getRegionName() {
        return regionName;
    }

    public String getCityName() {
        return cityName;
    }

    public Integer getRegionCode() {
        return regionCode;
    }

    public String getDepartementCode() {
        return departementCode;
    }

    public String getHref() {
        return href;
    }

    @Override
    public String toString() {
        return "SearchResult{" +
                "id=" + id +
                ", departementName='" + departementName + '\'' +
                ", regionName='" + regionName + '\'' +
                ", cityName='" + cityName + '\'' +
                ", regionCode=" + regionCode +
                ", departementCode='" + departementCode + '\'' +
                ", href='" + href + '\'' +
                '}';
    }
}
