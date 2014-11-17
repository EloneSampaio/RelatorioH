<?php

namespace DoctrineProxies\__CG__\models;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Equipamentos extends \models\Equipamentos implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = array();



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return array('__isInitialized__', '' . "\0" . 'models\\Equipamentos' . "\0" . 'id', '' . "\0" . 'models\\Equipamentos' . "\0" . 'nome', '' . "\0" . 'models\\Equipamentos' . "\0" . 'descricao', '' . "\0" . 'models\\Equipamentos' . "\0" . 'tipo', '' . "\0" . 'models\\Equipamentos' . "\0" . 'modelo', '' . "\0" . 'models\\Equipamentos' . "\0" . 'racks', '' . "\0" . 'models\\Equipamentos' . "\0" . 'usuarios');
        }

        return array('__isInitialized__', '' . "\0" . 'models\\Equipamentos' . "\0" . 'id', '' . "\0" . 'models\\Equipamentos' . "\0" . 'nome', '' . "\0" . 'models\\Equipamentos' . "\0" . 'descricao', '' . "\0" . 'models\\Equipamentos' . "\0" . 'tipo', '' . "\0" . 'models\\Equipamentos' . "\0" . 'modelo', '' . "\0" . 'models\\Equipamentos' . "\0" . 'racks', '' . "\0" . 'models\\Equipamentos' . "\0" . 'usuarios');
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Equipamentos $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', array());
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', array());
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId()
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', array());

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getNome()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNome', array());

        return parent::getNome();
    }

    /**
     * {@inheritDoc}
     */
    public function setNome($nome)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNome', array($nome));

        return parent::setNome($nome);
    }

    /**
     * {@inheritDoc}
     */
    public function getDescricao()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDescricao', array());

        return parent::getDescricao();
    }

    /**
     * {@inheritDoc}
     */
    public function getModelo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getModelo', array());

        return parent::getModelo();
    }

    /**
     * {@inheritDoc}
     */
    public function getRacks()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getRacks', array());

        return parent::getRacks();
    }

    /**
     * {@inheritDoc}
     */
    public function setId($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setId', array($id));

        return parent::setId($id);
    }

    /**
     * {@inheritDoc}
     */
    public function setDescricao($descricao)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDescricao', array($descricao));

        return parent::setDescricao($descricao);
    }

    /**
     * {@inheritDoc}
     */
    public function setModelo($modelo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setModelo', array($modelo));

        return parent::setModelo($modelo);
    }

    /**
     * {@inheritDoc}
     */
    public function setRacks(\models\Racks $racks)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setRacks', array($racks));

        return parent::setRacks($racks);
    }

    /**
     * {@inheritDoc}
     */
    public function getUsuarios()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUsuarios', array());

        return parent::getUsuarios();
    }

    /**
     * {@inheritDoc}
     */
    public function setUsuarios(\models\Usuarios $usuarios)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setUsuarios', array($usuarios));

        return parent::setUsuarios($usuarios);
    }

    /**
     * {@inheritDoc}
     */
    public function getTipo()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getTipo', array());

        return parent::getTipo();
    }

    /**
     * {@inheritDoc}
     */
    public function setTipo($tipo)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setTipo', array($tipo));

        return parent::setTipo($tipo);
    }

    /**
     * {@inheritDoc}
     */
    public function Insert($objecto, $rack)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'Insert', array($objecto, $rack));

        return parent::Insert($objecto, $rack);
    }

    /**
     * {@inheritDoc}
     */
    public function listarEquip($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'listarEquip', array($id));

        return parent::listarEquip($id);
    }

    /**
     * {@inheritDoc}
     */
    public function listaAll()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'listaAll', array());

        return parent::listaAll();
    }

    /**
     * {@inheritDoc}
     */
    public function Update($dados)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'Update', array($dados));

        return parent::Update($dados);
    }

    /**
     * {@inheritDoc}
     */
    public function pesquisa($pesquisa)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'pesquisa', array($pesquisa));

        return parent::pesquisa($pesquisa);
    }

    /**
     * {@inheritDoc}
     */
    public function Delete($id)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'Delete', array($id));

        return parent::Delete($id);
    }

    /**
     * {@inheritDoc}
     */
    public function pesquisaEquipamentos($id = NULL)
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'pesquisaEquipamentos', array($id));

        return parent::pesquisaEquipamentos($id);
    }

    /**
     * {@inheritDoc}
     */
    public function listagem()
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'listagem', array());

        return parent::listagem();
    }

}
