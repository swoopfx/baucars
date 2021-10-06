<?php
/**
 * WasabiLib http://www.wasabilib.org
 *
 * @link https://github.com/WasabilibOrg/wasabilib
 * @license The MIT License (MIT) Copyright (c) 2015 Nico Berndt, Norman Albusberger, Sascha Qualitz
 *
THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
 */

namespace WasabiLib\Wizard;

use Laminas\Session\Container;
use Laminas\Session\ManagerInterface as Manager;

class StorageContainer extends Container {

    protected $name;
    public function __construct($name = 'Default', Manager $manager = null){
        parent::__construct($name,$manager);
        $this->name = $name;
        
    }

//    protected function offsetSet($key, $value) {
//        parent::offsetSet($key, $value);
//    }
//
//    public function offsetGet($key) {
//        parent::offsetGet($key);
//    }

    public function set($key, $value) {
        parent::offsetSet($key, $value);
    }

    public function get($key) {
       return parent::offsetGet($key);
    }


    public function clearStorage(){
        $this->getStorage()->clear($this->name);
    }

}