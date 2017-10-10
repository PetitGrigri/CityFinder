package com.esgi.cityfinder.Model;

/**
 * Created by Asif on 10/10/2017.
 */

public class DetailCity {

    private String title;
    private boolean isHeader;

    public DetailCity(String title, boolean isHeader) {
        this.title = title;
        this.isHeader = isHeader;
    }

    public String getTitle() {
        return title;
    }

    public boolean isHeader() {
        return isHeader;
    }

    @Override
    public String toString() {
        return "DetailCity{" +
                "title='" + title + '\'' +
                ", isHeader=" + isHeader +
                '}';
    }
}
