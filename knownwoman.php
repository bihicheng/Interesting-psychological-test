<?php
require ('pinyin.php');

class KnownWoman{

    protected  $womanType = 0;
    protected  $womanInfo = array(
        'apple1' => array('苹果女人', '
        '),
        'ichee2' => array('荔枝女人', '

        '),
        'peach3' => array('水蜜桃女人', '

        '),
        'orange4' => array('橘子女人', '

        '),
        'grape5' => array('葡萄女人', '

        '),
        'banana6' => array('香蕉女人', '

        '),
        'strawberry7' => array('草莓女人', '
        '),
        'pipeapple8' => array('菠萝女人', '

        '),
        'chinese_goosebeery9' =>array('猕猴桃女人', '

        '),
        'mango10' => array('芒果女人', '

        ')
     );
    /**
     * 
     * 中文名字转换成英文字母字符串
     * name_zh2en method
     *
     * @return string
     * @access protected
     * @author Bi Haicheng
     **/
    final protected function name_zh2en($zh_name)
    {
        return Pinyin($zh_name);
    }
    /**
     * 按照规则将字符串转换成数字并取得最后一位数字
     *
     *  str2num function
     *
     * @return int $num
     * @access protected
     * @author Bi Haicheng
     **/
    final protected function str2num($str = array())
    {
        $str = str_split($str);
        $num = 0;
        foreach ($str as $v) {
            if(
                $v == 'a' ||
                $v == 'g' ||
                $v == 'l' ||
                $v == 'w' ||
                $v == 'y'
            )
                $num+=1;
            elseif(
                $v == 'n' || 
                $v == 'f' || 
                $v == 'o' || 
                $v == 'p' || 
                $v == 'q' || 
                $v == 'r' || 
                $v == 'x'
                )
                $num+=3;
            else
                $num+=2;
        }
        $lastchar = substr(strval($num), -1);
        return $lastchar;
    }

    protected function filterStrAndEncode ($str)
    {
       return  mb_convert_encoding(trim(strip_tags($str)));
    }
    /**
     *
     * 根据名字得到女人类型
     *
     * @return void
     * @access protected
     * @author Bi Haicheng
     **/
    protected function getWomanTypeBy($name)
    {
        //英文名字
        if (preg_match('/^[\\x00-\\x7F]*$/', $name)) {
            $this->womanType = $this-> str2num($name);
        }
        //中文名字
        elseif(preg_match('/^[\x80-\xff_a-zA-Z0-9]+$/', $name)){
            $this->womanType = $this->str2num($this->name_zh2en($name));
        }
        //其他字母暂不支持
        else{
            echo '只支持纯中文，纯英文';
        }
    }
    /**
     * 显示女人性格
     *
     * showInfoByname method
     *
     * @return void
     * @access public
     * @author Bi Haicheng
     **/
    public function showInfoByname()
    {
        $name = isset($_POST['name']) ? $this->filterStrAndEncode($_POST['name']) :
            ((isset($_SERVER['argc']) && $_SERVER['argc']>=1 ) ? $_SERVER['argv'][1] : null);
        if ($name) {
            $this->getWomanTypeBy($name);
            foreach($this->womanInfo as $k => $v){
                if($this->womanType == (int)substr($k,-1)){
                   echo  $v[0]."<br />".$v[1];
                }
            }
        }
        else{
            echo '请输入女人的名字';
        }
    }

}
$kw = new KnownWoman();
$kw -> showInfoByName();
?>
