<?
class UserIdentity extends CUserIdentity
{
	private $_id;
	private $firstname;
	private $lastname;
	private $full_name;
	private $ds = null;

    public function authenticate()
    {
		if ($this->ds === null)
		{
			$this->ds = ldap_connect(param('ldap_server'));
			ldap_set_option($this->ds, LDAP_OPT_PROTOCOL_VERSION, 3);
			ldap_set_option($this->ds, LDAP_OPT_REFERRALS, 0);
		}
		if ($this->ds)
		{
			try
			{
				$r = @ldap_bind($this->ds, 'uid='.$this->username.','.param('ldap_users_dn'), $this->password);
			}
			catch (Exception $e)
			{
				$this->errorCode=self::ERROR_PASSWORD_INVALID;
			}
			if ($r)
			{
				$this->errorCode=self::ERROR_NONE;
				$this->refreshUser();
				$this->setState('firstname', $this->firstname);
				$this->setState('lastname', $this->lastname);
				$this->setState('full_name', $this->full_name);
				$this->setState('active_tab', '');
			}
			else $this->errorCode=self::ERROR_PASSWORD_INVALID;
			ldap_close($this->ds);
			$this->ds = null;
		}
		return !$this->errorCode;
    }

    public function getId()
    {
        return $this->_id;
    }
    
    protected function refreshUser()
    {
		$entry = $this->readLdapEntry();

		$user=User::model()->find('username=?', array($this->username));
		if ($user === null)
		{
			$user = new User;
			$user->username = $this->username;
			$user->firstname = $entry[0]['givenname'][0];
			$user->lastname = $entry[0]['sn'][0];
			$user->email = $entry[0]['mail'][0];
		}
		else
		{
			$user->firstname = $entry[0]['givenname'][0];
			$user->lastname = $entry[0]['sn'][0];
			$user->email = $entry[0]['mail'][0];			
		}
		$user->save();
		$this->_id = $user->id;		
		$this->firstname = $user->firstname;
		$this->lastname = $user->lastname;
		$this->full_name = $user->full_name;
		
		$this->refreshPerms();
    }
    
    protected function refreshPerms()
    {
		$itemadmin = $allotmentadmin = false;
		if ($this->checkGroup('allot-admin')) $itemadmin = true;
		if ($this->checkGroup('allot-allotment')) $allotmentadmin = true;
		
		if (!am()->isAssigned('CommonUser', $this->id))
			am()->assign('CommonUser', $this->id);
		
		if (am()->isAssigned('ItemAdmin', $this->id))
		{
			if (!$itemadmin) am()->revoke('ItemAdmin', $this->id);
		}
		elseif ($itemadmin) am()->assign('ItemAdmin', $this->id);
		
		if (am()->isAssigned('AllotmentAdmin', $this->id))
		{
			if (!$allotmentadmin) am()->revoke('AllotmentAdmin', $this->id);
		}
		elseif ($allotmentadmin) am()->assign('AllotmentAdmin', $this->id);
		
		am()->save();
    }
    
    protected function readLdapEntry()
    {
		$sr = ldap_read($this->ds, 'uid='.$this->username.','.param('ldap_users_dn'), '(objectclass=*)', array('givenname', 'sn', 'mail'));
		return ldap_get_entries($this->ds, $sr);
    }
    
    protected function checkGroup($group)
    {
		$sr = @ldap_read($this->ds, 'cn='.$group.','.param('ldap_groups_dn'), '(objectclass=*)', array('memberuid'));
		if ($sr)
		{
			$entry = ldap_get_entries($this->ds, $sr);
			if (in_array($this->username, $entry[0]['memberuid'])) return true; else return false;
		}
		else return false;
	}
}
