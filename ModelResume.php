<?php
class ModelResume extends DAO
    {
      	private static $instance ;

      
        public static function newInstance()
        {
            if( !self::$instance instanceof self ) {
                self::$instance = new self ;
            }
            return self::$instance ;
        }

       
        function __construct()
        {
            parent::__construct();
        }
		
		
		public function import($file)
        {
            $path = osc_plugin_resource($file) ;
            $sql = file_get_contents($path);

            if(! $this->dao->importSQL($sql) ){
                throw new Exception( "Error importSQL::ModelResume<br>".$file ) ;
            }
        }
		
      
        public function getTable_ResumeUploader()
        {
            return DB_TABLE_PREFIX.'t_resume_uploader' ;
        }
		
		
		
		
		public function uninstall()
        {
			$this->dao->query(sprintf('DROP TABLE %s', $this->getTable_ResumeUploader()) ) ;
		}
		
		public function checkResume($user ="")
        {
			$this->dao->select();
            $this->dao->from( $this->getTable_ResumeUploader() ) ;
			$this->dao->where('fk_i_user_id', $user);
			
			$result = $this->dao->get();
            if($result == false) {
                return 0;
            }
			$resume = $result->row();
            return $resume['fk_i_user_id'];
         }
		
		
		public function getResume($user ="")
        {
			$this->dao->select();
            $this->dao->from( $this->getTable_ResumeUploader() ) ;
			$this->dao->where('fk_i_user_id', $user);
			
			$result = $this->dao->get();
            if($result == false) {
                return 0;
            }
            $resume = $result->row();
            return $resume;
		}
		
		public function viewResumeByCode($code)
        {
			$this->dao->select();
            $this->dao->from( $this->getTable_ResumeUploader() ) ;
			$this->dao->where('code', $code);
			
			$result = $this->dao->get();
            if($result == false) {
                return 0;
            }
			$resume = $result->row();
            return $resume;
		}
	
	
		
		public function insertResume( $name, $user, $code, $ext)
        {
            return $this->dao->insert($this->getTable_ResumeUploader(), array('name' => $name, 'fk_i_user_id' => $user, 'code' => $code, 'ext' => $ext, 'date' => date("Y-m-d"))) ;
        }
		
		public function updateViews( $code, $view) {
			$aSet = array('views' => $view+1);
			$aWhere = array('code' => $code);
		
			return $this->_update($this->getTable_ResumeUploader(), $aSet, $aWhere);
		  }
		
		
		
		 public function deleteResume() {
            return $this->dao->delete( $this->getTable_ResumeUploader(), array('fk_i_user_id' => osc_logged_user_id()) ) ;
        }
		 
       
    }
?>