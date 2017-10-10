package com.esgi.cityfinder.Model;

import android.os.Parcel;
import android.os.Parcelable;

import com.esgi.cityfinder.R;
import com.google.gson.annotations.SerializedName;

/**
 * Created by Asifadam93 on 08/10/2017.
 */

public class SearchResult implements Parcelable {

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

    private String imageUrl;

    private int imageId;

    public SearchResult() {
        imageId = R.drawable.default_image;
    }

    public SearchResult(Integer id, String cityName, int imageId) {
        this.cityName = cityName;
        this.imageId = imageId;
    }

    public SearchResult(String cityName, String imageUrl) {
        this.cityName = cityName;
        this.imageUrl = imageUrl;
        this.imageId = -1;
    }

    protected SearchResult(Parcel in) {
        id = in.readInt();
        departementName = in.readString();
        regionName = in.readString();
        cityName = in.readString();
        departementCode = in.readString();
        href = in.readString();
        imageUrl = in.readString();
        imageId = in.readInt();
    }

    public static final Creator<SearchResult> CREATOR = new Creator<SearchResult>() {
        @Override
        public SearchResult createFromParcel(Parcel in) {
            return new SearchResult(in);
        }

        @Override
        public SearchResult[] newArray(int size) {
            return new SearchResult[size];
        }
    };

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

    public String getImageUrl() {
        return imageUrl;
    }

    public int getImageId() {
        return imageId;
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
                ", imageUrl='" + imageUrl + '\'' +
                ", imageId='" + imageId + '\'' +
                '}';
    }

    @Override
    public int describeContents() {
        return 0;
    }

    @Override
    public void writeToParcel(Parcel parcel, int i) {
        parcel.writeInt(id);
        parcel.writeString(departementName);
        parcel.writeString(regionName);
        parcel.writeString(cityName);
        parcel.writeString(departementCode);
        parcel.writeString(href);
        parcel.writeString(imageUrl);
        parcel.writeInt(imageId);
    }
}
