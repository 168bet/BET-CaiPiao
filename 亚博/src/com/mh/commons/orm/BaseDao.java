package com.mh.commons.orm;

import java.io.Serializable;
import java.sql.ResultSet;
import java.sql.ResultSetMetaData;
import java.sql.SQLException;
import java.util.Comparator;
import java.util.List;
import java.util.Map;

import org.apache.commons.lang3.StringUtils;
import org.apache.commons.lang3.builder.ToStringBuilder;
import org.hibernate.HibernateException;
import org.hibernate.Query;
import org.hibernate.SQLQuery;
import org.hibernate.Session;
import org.hibernate.transform.Transformers;
import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.jdbc.core.JdbcTemplate;
import org.springframework.jdbc.core.RowMapper;
import org.springframework.orm.hibernate3.HibernateCallback;
import org.springframework.orm.hibernate3.HibernateTemplate;
import org.springframework.orm.hibernate3.SessionFactoryUtils;
import org.springframework.util.Assert;

import com.google.common.collect.Maps;
import com.mh.commons.utils.Reflections;



/**
 * @ClassName: BaseDao 
 * @Description: TODO(DAO基类，其它DAO可以直接继承这个DAO，不但可以复用共用的方法，还可以获得泛型的好处。) 
 * @author Victor.Chen chenld_fzu@163.com
 * @date Mar 24, 2012 4:08:57 PM 
 * 
 * @param <T>
 * @param <PK>
 */
@SuppressWarnings("all")
public class BaseDao<T,  PK extends Serializable>{
	protected Logger logger = LoggerFactory.getLogger(getClass());
	private Class<T> entityClass;
	
	@Autowired
	private HibernateTemplate hibernateTemplate;
	
	@Autowired
	private JdbcTemplate jdbcTemplate;
	
	/**
	 * 通过反射获取子类确定的泛型类
	 */
	public BaseDao() {
		entityClass = Reflections.getSuperClassGenricType(getClass());
	}
	
	/**
	 * 用于用于省略Dao层, 在Service层直接使用通用的BaseDao构造函数.
	 * 在构造函数中定义对象类型Class.
	 * eg.
	 * BaseDao<User, Long> userDao = new BaseDao<User, Long>(User.class);
	 */
	public BaseDao(Class<T> entityClass) {
		this.entityClass = entityClass;
	}

	/**
	 * 根据ID加载PO实例, 如果二级缓存中存在, 则读取二级缓存的数据
	 * 
	 * @param id
	 * @return 返回相应的持久化PO实例
	 */
	public T load(PK id) {
		Assert.notNull(id);
		
		if(logger.isDebugEnabled()){
			logger.debug("load entity id[" + id + "], entityClass[" + entityClass + "]");
		}
		return (T) hibernateTemplate.load(entityClass, id);
	}

	/**
	 * 根据ID获取PO实例, 如果一级缓存不存在, 则从数据库中读取
	 * 
	 * @param id
	 * @return 返回相应的持久化PO实例
	 */
	public T get(PK id) {
		Assert.notNull(id);
		
		if(logger.isDebugEnabled()){
			logger.debug("get entity id[" + id + "], entityClass[" + entityClass + "]");
		}
		T t =(T) hibernateTemplate.get(entityClass, id);
		
		return t;
	}

	/**
	 * 获取PO的所有对象
	 * 
	 * @return
	 */
	public List<T> loadAll() {
		
		List<T> lst = hibernateTemplate.loadAll(entityClass);
		
		if(logger.isDebugEnabled()){
			logger.debug("load all entities[" + entityClass + "]...");
		}
		return lst;
	}
	
	/**
	 * 保存PO
	 * 
	 * @param entity
	 */
	public Serializable save(T entity) {
		Assert.notNull(entity);
		
		if(logger.isDebugEnabled()){
			logger.debug("save entity[" + entity.toString() + "], entityClass[" + entityClass + "]," +
					" information[" + ToStringBuilder.reflectionToString(entity) + "]");
		}
		return hibernateTemplate.save(entity);
	}

	/**
	 * 删除PO
	 * 
	 * @param entity
	 */
	public void delete(T entity) {
		Assert.notNull(entity);
		
		if(logger.isDebugEnabled()){
			logger.debug("delete entity[" + entity.toString() + "], entityClass[" + entityClass + "], " +
					"information[" + ToStringBuilder.reflectionToString(entity) + "]");
		}
		hibernateTemplate.delete(entity);
	}

	/**
	 * 更新PO
	 * 
	 * @param entity
	 */
	public void update(T entity) {
		Assert.notNull(entity);
		
		if(logger.isDebugEnabled()){
			logger.debug("update entity[" + entity.toString() + "], entityClass[" + entityClass + "]," +
					" information[" + ToStringBuilder.reflectionToString(entity) + "]");
		}
		hibernateTemplate.update(entity);
	}
	
	/**
	 * 保存或更新PO
	 * 
	 * @param entity
	 */
	public void saveOrUpdate(T entity) {
		Assert.notNull(entity);
		
		if(logger.isDebugEnabled()){
			logger.debug("saveOrUpdate entity[" + entity.toString() + "], entityClass[" + entityClass + "], " +
					"information[" + ToStringBuilder.reflectionToString(entity) + "]");
		}
		hibernateTemplate.saveOrUpdate(entity);
	}
	
	/**
	 * 
	 * @param entity
	 */
	public void merge(T entity) {
		Assert.notNull(entity);
		
		if(logger.isDebugEnabled()){
			logger.debug("merge entity[" + entity.toString() + "], entityClass[" + entityClass + "], " +
					"information[" + ToStringBuilder.reflectionToString(entity) + "]");
		}
		hibernateTemplate.merge(entity);
	}

	/**
	 * 执行带参的HQL查询
	 * 
	 * @param sql
	 * @param params
	 * @return 查询结果
	 */
	public List find(String hql, Object... params) {
		Assert.hasText(hql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + hql + "], entityClass[" + entityClass + "], " +
					"params[" + ToStringBuilder.reflectionToString(params) + "]");
		}
		
		List lst = hibernateTemplate.find(hql, params);
		
		return lst;
	}
	
	/**
	 * 按SQL查询结果, 
	 * 注与HQL混合使用时事项, 原生SQL查询不到在同一事务下session级save/delete等操作影响数据表
	 *  
	 * @param hql
	 * @param params
	 * @return List<Map<String, Object>>, key:大写表字段名
	 */
	public List<Map<String, Object>> findBySql(final String sql, final Object... params) {
		Assert.hasText(sql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + sql + "], params[" + ToStringBuilder.reflectionToString(params) + "]");
		}
		
		List<Map<String, Object>> result = hibernateTemplate.executeFind(new HibernateCallback() {

			public List<Map<String, Object>> doInHibernate(Session session) throws HibernateException, SQLException {
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(sql).setResultTransformer(Transformers.ALIAS_TO_ENTITY_MAP);
				
				if (params != null) {
					for (int i = 0; i < params.length; i++) {
						sqlQuery.setParameter(i, params[i]);
					}
				}
				
				return (List<Map<String, Object>>)sqlQuery.list();
			}
		});
		return result;
	}
	
	
	/**
	 * 按HQL查询唯一对象.
	 * 
	 * @param params 数量可变的参数,按顺序绑定.
	 */
	public <X> X findUnique(final String hql, final Object... params) {
		Assert.hasText(hql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + hql + "], params[" + ToStringBuilder.reflectionToString(params) + "]");
		}
		
		 return getHibernateTemplate().execute(new HibernateCallback<X>() {
			public X doInHibernate(Session session) throws HibernateException, SQLException {
				Query query = session.createQuery(hql);
				if (params != null) {
					for (int i = 0; i < params.length; i++) {
						query.setParameter(i, params[i]);
					}
				}
				return (X) query.setMaxResults(1).uniqueResult();
			}
		});   
	}
	
    
	/**
	 * 对延迟加载的实体PO执行初始化
	 * 
	 * @param entity
	 */
	public void initialize(Object entity) {
		Assert.notNull(entity);
		hibernateTemplate.initialize(entity);
	}
	
	/**
	 * 刷新session缓存, 将缓存同步数据库
	 */
	public void flush(){
		hibernateTemplate.flush();
	}
	
	/**
	 * 按HQL分页查询.
	 * 
	 * @param page 分页参数.不支持其中的orderBy参数.
	 * @param hql hql语句.
	 * @param params 数量可变的查询参数,按顺序绑定.
	 * 
	 * @return 分页查询结果, 附带结果列表及所有查询时的参数.
	 */
	public <X> Page<X>  findPage(final Page<X> page, final String hql, final Object... params) {
		Assert.notNull(page);
		Assert.hasText(hql);
		
		return findPage(page, hql, null, params);
	}
	
	/**
	 * 按HQL分页查询.
	 * 
	 * @param page 分页参数.不支持其中的orderBy参数.
	 * @param hql hql语句.
	 * @param countHql 自定义查询总数, 用户未定义, 请赋值null
	 * @param params 数量可变的查询参数,按顺序绑定.
	 * 
	 * @return 分页查询结果, 附带结果列表及所有查询时的参数.
	 */
	public <X> Page<X> findPage(final Page<X> page, final String hql, final String countHql, final Object... params) {
		Assert.notNull(page);
		Assert.hasText(hql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + hql + "]," +
					" countHql[" + countHql + "]," +
					" params[" + ToStringBuilder.reflectionToString(params) + "], " +
					" page["+ToStringBuilder.reflectionToString(page)+"]");
		}
		
		hibernateTemplate.executeFind(new HibernateCallback(){
			public List<X> doInHibernate(Session session) throws HibernateException, SQLException {
				Assert.hasText(hql);
				Query query = session.createQuery(hql);
				
				if(params != null){
					for (int i = 0; i < params.length; i++) {
						query.setParameter(i, params[i]);
					}
				}
				
				if (page.isAutoCount()) {
					long totalCount = countHqlResult(hql, countHql, params);
					page.setTotalCount(totalCount);
				}
				
				setPageParameter(query, page);
				page.setResult(query.list());
				return page.getResult();
			}

		});
		
		return page;
		
	}
	
	/**
	 * 按SQL查询分页
	 * @param page 分页参数.不支持其中的orderBy参数.
	 * @param sql
	 * @param params 数量可变的查询参数,按顺序绑定.
	 * @return
	 */
	public Page<Map<String, Object>> findPageBySql(final Page<Map<String, Object>> page, final String sql, final Object... params) {
		Assert.notNull(page);
		Assert.hasText(sql);
		return findPageBySql(page, sql, null, params);
	}
	
	/**
	 * 按SQL查询分页
	 * 注: 返回page封装数据result结构:List<Map<String, Object>>, key:如果查询 SQL 未写as, 则key取大写表字段名, 否则取as 命名
	 * @param page 分页参数.不支持其中的orderBy参数.
	 * @param sql
	 * @param countSql 自定义查询总数
	 * @param params 数量可变的查询参数,按顺序绑定.
	 * @return Page,
	 * 
	 */
	public Page<Map<String, Object>> findPageBySql(final Page<Map<String, Object>> page, final String sql, final String countSql, final Object... params) {
		Assert.notNull(page);
		Assert.hasText(sql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + sql + "]," +
					" countHql[" + countSql + "]," +
					" params[" + ToStringBuilder.reflectionToString(params) + "], " +
					" page["+ToStringBuilder.reflectionToString(page)+"], " 
					);
		}
		
		 hibernateTemplate.executeFind(new HibernateCallback() {
			public Object doInHibernate(Session session) throws HibernateException, SQLException {
				SQLQuery sqlQuery = (SQLQuery)session.createSQLQuery(sql).setResultTransformer(Transformers.ALIAS_TO_ENTITY_MAP);
				if (params != null) {
					for (int i = 0; i < params.length; i++) {
						sqlQuery.setParameter(i, params[i]);
					}
				}
				
				if (page.isAutoCount()) {
					long totalCount = countSqlResult(sql, countSql, params);
					page.setTotalCount(totalCount);
				}
				
				setPageParameter(sqlQuery, page);
				page.setResult(sqlQuery.list());
				return (List<Map<String, Object>>)page.getResult();
			}
		});
		 
		 return page;
	}
	
	/**
	 * SQL查询记录, 返回对象列表(需实现rowMapper接口) 不支持分页
	 * @param <T>
	 * @param sql
	 * @param rowMapper
	 * @param params
	 * @return
	 */
	public <T> List<T> findByNativeSql(final String sql, final RowMapper<T> rowMapper, final Object... params) {
		Assert.hasText(sql);
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + sql + "], params[" + ToStringBuilder.reflectionToString(params) + "]");
		}
		
		return this.jdbcTemplate.query(sql, rowMapper, params);
	}
	
	/**
	 * SQL查询记录, 返回按顺序查询字段 不支持分页
	 * @param nativeSQL
	 * @param params
	 * @return
	 */
	public List<Map<String, Object>> findListsByNativeSQL(String nativeSQL, final Object... params){
		Assert.hasText(nativeSQL);
		logger.debug("find entities[{}], params[{}]", nativeSQL, ToStringBuilder.reflectionToString(params));
		
		List<Map<String, Object>> list = 
		 this.getJdbcTemplate().query(nativeSQL, new RowMapper<Map<String, Object>>(){

			public Map<String, Object> mapRow(ResultSet rs, int rowNum) throws SQLException {
				Map<String, Object> map = Maps.newLinkedHashMap(); //按查询字段放值
				ResultSetMetaData rsmd = rs.getMetaData();
				
	        	for (int num = 1; num < rsmd.getColumnCount()+1; num ++) {
	        		map.put(rsmd.getColumnName(num), rs.getObject(num)); //索引从1开始
				}
				return map;
			}
			
		}, params);
		
		return list;
	}
	
	/**
	 * SQL查询记录, 不支持分页, 外层Map key:primaryKey在库表中的值, 内层Map: 表示一条数据记录
	 * @param nativeSQL
	 * @param primaryKey 主键在数据库中的标识
	 * @param params
	 * @return
	 */
	public Map<Long, Map<String, Object>> findMapsByNativeSQL(String nativeSQL, final String primaryKey, final Object... params){
		Assert.hasText(nativeSQL);
		logger.debug("find entities[{}], params[{}]", nativeSQL, ToStringBuilder.reflectionToString(params));
		
		List<Map<String, Object>> rowList = findListsByNativeSQL(nativeSQL, params);
		Map<Long, Map<String, Object>> rowMaps = Maps.newTreeMap(new Comparator<Long>(){

			public int compare(Long o1, Long o2) {
				return o1.compareTo(o2);
			}
			
		});
		
		for(Map<String, Object> rowMap : rowList){
			Long keyValue = (Long)rowMap.get(primaryKey);
			if(keyValue != null){
				rowMaps.put(keyValue, rowMap);
			}
		}
		
		return rowMaps;
	}
	
	/**
	 * 批量执行hql语句, 包括删除和更新
	 * 注: 可执行批量更新操作, 立即执行相关HQL语句操作, 与session级缓存同步(在删除或更新前自动检查session缓存脏数据)
	 * eg: hql: delete from User u where u.userName = ?
	 * 
	 * @param hql
	 * @param params
	 * @return 返回影响行数
	 */
	public Long executeUpdate(final String hql, final Object... params) {
		Assert.hasText(hql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + hql + "]," + " params[" + ToStringBuilder.reflectionToString(params) + "] ");
		}
		
		return hibernateTemplate.execute(new HibernateCallback<Long>() {
			public Long doInHibernate(Session session) throws HibernateException, SQLException {
				Query query = session.createQuery(hql);
				if(params != null){
					for (int i = 0; i < params.length; i++) {
						query.setParameter(i, params[i]);
					}
				}
				return new Long(query.executeUpdate());
			}
			
		});
		
		
	}
	/**
	 * 批量执行hql语句, 包括删除和更新(改了一下参数由动态参数变为obejce数组，以免参数过多，不好维护)
	 * 注: 可执行批量更新操作, 立即执行相关HQL语句操作, 与session级缓存同步(在删除或更新前自动检查session缓存脏数据)
	 * eg: hql: delete from User u where u.userName = ?
	 * @author Andy
	 * @param hql
	 * @param params
	 * @return 返回影响行数
	 */
	public Integer executeUpdateForAndy(final String hql, final Object[] params) {
		Assert.hasText(hql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + hql + "]," + " params[" + ToStringBuilder.reflectionToString(params.toString()) + "] ");
		}
		
		return hibernateTemplate.execute(new HibernateCallback<Integer>() {
			public Integer doInHibernate(Session session) throws HibernateException, SQLException {
				Query query = session.createQuery(hql);
				if(params != null){
					for (int i = 0; i < params.length; i++) {
						query.setParameter(i, params[i]);
					}
				}
				return query.executeUpdate();
			}
			
		});
		
		
	}
	
	/**
	 * 批量执行sql语句, 包括删除和更新
	 * 注: 可执行批量更新操作, 立即执行相关SQL语句操作, 因此需要注意:要处理hibernate session缓存中的Java对象(需要手动删除session脏缓存数据)
	 * @param hql
	 * @param params
	 * @return 返回影响行数
	 */
	public Long executeUpdateBySql(final String sql, final Object... params) {
		Assert.hasText(sql);
		
		if(logger.isDebugEnabled()){
			logger.debug("find entities[" + sql + "]," + " params[" + ToStringBuilder.reflectionToString(params) + "] ");
		}
		
		return hibernateTemplate.execute(new HibernateCallback<Long>() {
			public Long doInHibernate(Session session) throws HibernateException, SQLException {
				SQLQuery query = session.createSQLQuery(sql);
				if(params != null){
					for (int i = 0; i < params.length; i++) {
						query.setParameter(i, params[i]);
					}
				}
				
				return new Long(query.executeUpdate());
			}
			
		});
		
	}
	
	
	/**
	 * 执行count查询获得本次Hql查询所能获得的对象总数.
	 * 本函数只能自动处理简单的hql语句,复杂的hql, 如含有多个order by 排序功能, 为了提高查询效率, 请另行传入countHql语句.
	 * @param hql
	 * @param countHql 计数SQL
	 * @param params 查询传入参数
	 * @return
	 */
	protected long countHqlResult(String hql, String countHql, final Object... params) {
		Assert.hasText(hql);
		String countHqlTmp = countHql;
		
		if(StringUtils.isBlank(countHql)){
			countHqlTmp = hql;
			
			//以select开头查询
			if(countHqlTmp.toLowerCase().trim().startsWith("select")){
				countHqlTmp = " select count(*) from ( " + countHqlTmp + " )";
			}
			else{
				countHqlTmp = " from " + StringUtils.substringAfter(countHqlTmp, "from");
				countHqlTmp = " select count (*) " + countHqlTmp;
			}
		}
		
		try {
			return  (Long)findUnique(countHqlTmp, params);
		} catch (Exception e) {
			throw new RuntimeException("hql can't be auto count, countHqlTmp is [" + countHqlTmp +"]", e);
		}
	}
	
	
	/**
	 * 执行count查询获得本次Hql查询所能获得的对象总数.
	 * 本函数只能自动处理简单的hql语句,复杂的hql, 如含有多个order by 排序功能, 为了提高查询效率, 请另行传入countHql语句.
	 * 
	 * @param hql
	 * @param countHql 计数SQL
	 * @param params 查询传入参数
	 * @return
	 */
	protected long countSqlResult(String Sql, String countSql, Object... params) {
		Assert.hasText(Sql);
		String countSqlTmp = countSql;
		
		if(StringUtils.isBlank(countSql)){
			countSqlTmp = Sql;
			
			//以select开头查询
			if(countSqlTmp.toLowerCase().trim().startsWith("select")){
				countSqlTmp = " select count(*) from ( " + countSqlTmp + " ) c";
			}
			else{
				countSqlTmp = " from " + StringUtils.substringAfter(countSqlTmp, "from") +" c";
				countSqlTmp = " select count(*) " + countSqlTmp;
			}
		}
	
		
		Long count = jdbcTemplate.queryForLong(countSqlTmp, params);
		
		if(count == null){
			return 0;
		}
		else{
			return count.longValue();
		}
	}
	
	/**
	 * 设置分页参数到Query对象,辅助函数.
	 */
	protected <X> Query setPageParameter(final Query q, final Page<X> page) {
		//hibernate的firstResult的序号从0开始
		q.setFirstResult(page.getFirst() - 1);
		q.setMaxResults(page.getPageSize());
		return q;
	}

	
	/**
	 * 从当前线程获取session, 如果没有, 则新建一个
	 * 包中都可见，而且其子类也能访问
	 * 注:使用时, 请判断获取的session是否属于当前事务, 如果取得的session不在事务上下文中, 需要手动release session
	 * @return
	 */
	private Session getSession() {
        return SessionFactoryUtils.getSession(hibernateTemplate.getSessionFactory(), true);
    }

	protected HibernateTemplate getHibernateTemplate() {
		return hibernateTemplate;
	}
	
	/**
	 * 强烈建议JdbcTemplate 实例用于查询操作
	 * @return
	 */
	protected JdbcTemplate getJdbcTemplate() {
		return jdbcTemplate;
	}
	
    
}