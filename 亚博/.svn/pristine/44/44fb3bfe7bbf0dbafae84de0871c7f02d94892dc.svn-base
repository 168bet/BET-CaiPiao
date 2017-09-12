package com.mh.entity;



import java.util.Date;

import javax.persistence.Column;
import javax.persistence.Entity;
import javax.persistence.GeneratedValue;
import javax.persistence.GenerationType;
import javax.persistence.Id;
import javax.persistence.Table;

@Entity
@Table(name = "T_WEB_FILEINFO")
public class TWebFileInfo {
   
	@Id
	@GeneratedValue(strategy = GenerationType.AUTO)//自增长
	@Column(name = "ID",nullable = false)
    private Integer id;
	
	@Column(name = "fileType")
    private String fileType;
	
	@Column(name = "fileName")
    private String fileName;
	
	@Column(name = "fileUrl")
    private String fileUrl;

	@Column(name = "fileFolder")
    private String fileFolder;
	
	@Column(name = "uploadTime")
    private Date uploadTime;
	
	@Column(name = "requestIp")
    private String requestIp;
	
	@Column(name = "fileBelong")
    private String fileBelong;

	public Integer getId() {
		return id;
	}

	public void setId(Integer id) {
		this.id = id;
	}

	public String getFileType() {
		return fileType;
	}

	public void setFileType(String fileType) {
		this.fileType = fileType;
	}

	public String getFileName() {
		return fileName;
	}

	public void setFileName(String fileName) {
		this.fileName = fileName;
	}

	public String getFileUrl() {
		return fileUrl;
	}

	public void setFileUrl(String fileUrl) {
		this.fileUrl = fileUrl;
	}

	public String getFileFolder() {
		return fileFolder;
	}

	public void setFileFolder(String fileFolder) {
		this.fileFolder = fileFolder;
	}

	public Date getUploadTime() {
		return uploadTime;
	}

	public void setUploadTime(Date uploadTime) {
		this.uploadTime = uploadTime;
	}

	public String getRequestIp() {
		return requestIp;
	}

	public void setRequestIp(String requestIp) {
		this.requestIp = requestIp;
	}

	public String getFileBelong() {
		return fileBelong;
	}

	public void setFileBelong(String fileBelong) {
		this.fileBelong = fileBelong;
	}

	
}