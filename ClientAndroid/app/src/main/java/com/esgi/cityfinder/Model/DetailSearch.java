package com.esgi.cityfinder.Model;

import com.esgi.cityfinder.Model.Centrales.Centrales20Km;
import com.esgi.cityfinder.Model.Centrales.Centrales30Km;
import com.esgi.cityfinder.Model.Centrales.Centrales80Km;
import com.esgi.cityfinder.Model.Hotel.HotelLocatedIn;
import com.esgi.cityfinder.Model.Hotel.HotelsNear;
import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Asif on 09/10/2017.
 */

public class DetailSearch {

    private Integer id;

    @SerializedName("name")
    private String cityName;

    @SerializedName("nomRegion")
    private String regionName;

    @SerializedName("nomDepartement")
    private String departementName;

    @SerializedName("centralesNear80km")
    private List<Centrales80Km> centrales80Km = null;

    @SerializedName("centralesNear30km")
    private List<Centrales30Km> centrales30Km = null;

    @SerializedName("centralesNear20km")
    private List<Centrales20Km> centrales20Km = null;

    @SerializedName("hotelsLocatedIn")
    private List<HotelsNear> hotelsNearList = null;

    @SerializedName("hotelsLocatedIn")
    private List<HotelLocatedIn> hotelLocatedInList = null;

    @SerializedName("museesLocatedIn")
    private List<Musees> museesList = null;

    @SerializedName("museesLocatedIn")
    private List<Poste> posteList = null;

    public DetailSearch(List<Centrales80Km> centrales80Km, List<Centrales30Km> centrales30Km,
                        List<Centrales20Km> centrales20Km, List<HotelsNear> hotelsNearList,
                        List<HotelLocatedIn> hotelLocatedInList, List<Musees> museesList, List<Poste> posteList) {
        this.centrales80Km = centrales80Km;
        this.centrales30Km = centrales30Km;
        this.centrales20Km = centrales20Km;
        this.hotelsNearList = hotelsNearList;
        this.hotelLocatedInList = hotelLocatedInList;
        this.museesList = museesList;
        this.posteList = posteList;
    }

    public Integer getId() {
        return id;
    }

    public String getCityName() {
        return cityName;
    }

    public String getRegionName() {
        return regionName;
    }

    public String getDepartementName() {
        return departementName;
    }

    public List<Centrales80Km> getCentrales80Km() {
        return centrales80Km;
    }

    public List<Centrales30Km> getCentrales30Km() {
        return centrales30Km;
    }

    public List<Centrales20Km> getCentrales20Km() {
        return centrales20Km;
    }

    public List<HotelsNear> getHotelsNearList() {
        return hotelsNearList;
    }

    public List<HotelLocatedIn> getHotelLocatedInList() {
        return hotelLocatedInList;
    }

    public List<Musees> getMuseesList() {
        return museesList;
    }

    public List<Poste> getPosteList() {
        return posteList;
    }
}
