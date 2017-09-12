package com.mh.web.login;

import java.io.IOException;
import java.io.OutputStream;
import java.util.Random;

import javax.servlet.ServletException;
import javax.servlet.http.HttpServlet;
import javax.servlet.http.HttpServletRequest;
import javax.servlet.http.HttpServletResponse;

import com.mh.commons.conf.CommonConstant;
import com.mh.web.servlet.MySessionContext;

/**
 * 验证码产生器servlet
 * 类描述: TODO<br/> 
 * 修改人: alex<br/>
 * 修改时间: 2015-6-24 下午7:51:01<br/>
 */
public class VerifiedServlet extends HttpServlet {

	private static final long serialVersionUID = -34545L;

	public VerifiedServlet() {
		super();
	}

	public void destroy() {
		super.destroy();
	}


	public void doGet(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {
		response.setContentType("image/jpeg");
		OutputStream out = response.getOutputStream();
		try {
			Random random = new Random();
			StringBuilder strb = new StringBuilder()
									.append(random.nextInt(10))
									.append(random.nextInt(10))
									.append(random.nextInt(10))
									.append(random.nextInt(10));
			//request.getSession().setAttribute(CommonConstant.VERITY_CODE_KEY, strb.toString());
			if(MySessionContext.getSession(request.getSession().getId())==null){
				MySessionContext.addSession(request.getSession());
			}
			MySessionContext.getSession(request.getSession().getId()).setAttribute(CommonConstant.VERITY_CODE_KEY, strb.toString());
			
			VerifiedCodeGenerator codeGenerator = new VerifiedCodeGenerator();
			codeGenerator.setImgWidth(60);
			codeGenerator.setImgHeight(22);
			codeGenerator.output(out, "jpg", codeGenerator.createImage(strb.toString()));
		} catch (Exception e) {
			e.printStackTrace();
		}finally{
			if(out != null)
				out.close();
		}
	}

	public void doPost(HttpServletRequest request, HttpServletResponse response)
			throws ServletException, IOException {

		this.doGet(request, response);
	}

	public void init() throws ServletException {
	}

}
