<?php
namespace Airavata\Model\AppCatalog\AppInterface;

/**
 * Autogenerated by Thrift Compiler (0.9.1)
 *
 * DO NOT EDIT UNLESS YOU ARE SURE THAT YOU KNOW WHAT YOU ARE DOING
 *  @generated
 */
use Thrift\Base\TBase;
use Thrift\Type\TType;
use Thrift\Type\TMessageType;
use Thrift\Exception\TException;
use Thrift\Exception\TProtocolException;
use Thrift\Protocol\TProtocol;
use Thrift\Protocol\TBinaryProtocolAccelerated;
use Thrift\Exception\TApplicationException;


final class DataType {
  const STRING = 0;
  const INTEGER = 1;
  const FLOAT = 2;
  const URI = 3;
  const STDOUT = 4;
  const STDERR = 5;
  static public $__names = array(
    0 => 'STRING',
    1 => 'INTEGER',
    2 => 'FLOAT',
    3 => 'URI',
    4 => 'STDOUT',
    5 => 'STDERR',
  );
}

final class ValidityType {
  const REQUIRED = 0;
  const OPTIONAL = 1;
  static public $__names = array(
    0 => 'REQUIRED',
    1 => 'OPTIONAL',
  );
}

final class CommandLineType {
  const INCLUSIVE = 0;
  const EXCLUSIVE = 1;
  static public $__names = array(
    0 => 'INCLUSIVE',
    1 => 'EXCLUSIVE',
  );
}

final class InputMetadataType {
  const MEMORY = 0;
  const CPU = 1;
  static public $__names = array(
    0 => 'MEMORY',
    1 => 'CPU',
  );
}

class InputDataObjectType {
  static $_TSPEC;

  public $name = null;
  public $value = null;
  public $type = null;
  public $applicationArgument = null;
  public $standardInput = false;
  public $userFriendlyDescription = null;
  public $metaData = null;
  public $inputOrder = null;
  public $inputValid = null;
  public $addedToCommandLine = null;
  public $dataStaged = false;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'value',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'type',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'applicationArgument',
          'type' => TType::STRING,
          ),
        5 => array(
          'var' => 'standardInput',
          'type' => TType::BOOL,
          ),
        6 => array(
          'var' => 'userFriendlyDescription',
          'type' => TType::STRING,
          ),
        7 => array(
          'var' => 'metaData',
          'type' => TType::STRING,
          ),
        8 => array(
          'var' => 'inputOrder',
          'type' => TType::I32,
          ),
        9 => array(
          'var' => 'inputValid',
          'type' => TType::I32,
          ),
        10 => array(
          'var' => 'addedToCommandLine',
          'type' => TType::I32,
          ),
        11 => array(
          'var' => 'dataStaged',
          'type' => TType::BOOL,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['name'])) {
        $this->name = $vals['name'];
      }
      if (isset($vals['value'])) {
        $this->value = $vals['value'];
      }
      if (isset($vals['type'])) {
        $this->type = $vals['type'];
      }
      if (isset($vals['applicationArgument'])) {
        $this->applicationArgument = $vals['applicationArgument'];
      }
      if (isset($vals['standardInput'])) {
        $this->standardInput = $vals['standardInput'];
      }
      if (isset($vals['userFriendlyDescription'])) {
        $this->userFriendlyDescription = $vals['userFriendlyDescription'];
      }
      if (isset($vals['metaData'])) {
        $this->metaData = $vals['metaData'];
      }
      if (isset($vals['inputOrder'])) {
        $this->inputOrder = $vals['inputOrder'];
      }
      if (isset($vals['inputValid'])) {
        $this->inputValid = $vals['inputValid'];
      }
      if (isset($vals['addedToCommandLine'])) {
        $this->addedToCommandLine = $vals['addedToCommandLine'];
      }
      if (isset($vals['dataStaged'])) {
        $this->dataStaged = $vals['dataStaged'];
      }
    }
  }

  public function getName() {
    return 'InputDataObjectType';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->name);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->value);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->type);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->applicationArgument);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->standardInput);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->userFriendlyDescription);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 7:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->metaData);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 8:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->inputOrder);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 9:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->inputValid);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 10:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->addedToCommandLine);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 11:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->dataStaged);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('InputDataObjectType');
    if ($this->name !== null) {
      $xfer += $output->writeFieldBegin('name', TType::STRING, 1);
      $xfer += $output->writeString($this->name);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->value !== null) {
      $xfer += $output->writeFieldBegin('value', TType::STRING, 2);
      $xfer += $output->writeString($this->value);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->type !== null) {
      $xfer += $output->writeFieldBegin('type', TType::I32, 3);
      $xfer += $output->writeI32($this->type);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationArgument !== null) {
      $xfer += $output->writeFieldBegin('applicationArgument', TType::STRING, 4);
      $xfer += $output->writeString($this->applicationArgument);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->standardInput !== null) {
      $xfer += $output->writeFieldBegin('standardInput', TType::BOOL, 5);
      $xfer += $output->writeBool($this->standardInput);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->userFriendlyDescription !== null) {
      $xfer += $output->writeFieldBegin('userFriendlyDescription', TType::STRING, 6);
      $xfer += $output->writeString($this->userFriendlyDescription);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->metaData !== null) {
      $xfer += $output->writeFieldBegin('metaData', TType::STRING, 7);
      $xfer += $output->writeString($this->metaData);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->inputOrder !== null) {
      $xfer += $output->writeFieldBegin('inputOrder', TType::I32, 8);
      $xfer += $output->writeI32($this->inputOrder);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->inputValid !== null) {
      $xfer += $output->writeFieldBegin('inputValid', TType::I32, 9);
      $xfer += $output->writeI32($this->inputValid);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->addedToCommandLine !== null) {
      $xfer += $output->writeFieldBegin('addedToCommandLine', TType::I32, 10);
      $xfer += $output->writeI32($this->addedToCommandLine);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->dataStaged !== null) {
      $xfer += $output->writeFieldBegin('dataStaged', TType::BOOL, 11);
      $xfer += $output->writeBool($this->dataStaged);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class OutputDataObjectType {
  static $_TSPEC;

  public $name = null;
  public $value = null;
  public $type = null;
  public $validityType = null;
  public $addedToCommandLine = null;
  public $dataMovement = null;
  public $dataNameLocation = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'name',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'value',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'type',
          'type' => TType::I32,
          ),
        4 => array(
          'var' => 'validityType',
          'type' => TType::I32,
          ),
        5 => array(
          'var' => 'addedToCommandLine',
          'type' => TType::I32,
          ),
        6 => array(
          'var' => 'dataMovement',
          'type' => TType::BOOL,
          ),
        7 => array(
          'var' => 'dataNameLocation',
          'type' => TType::STRING,
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['name'])) {
        $this->name = $vals['name'];
      }
      if (isset($vals['value'])) {
        $this->value = $vals['value'];
      }
      if (isset($vals['type'])) {
        $this->type = $vals['type'];
      }
      if (isset($vals['validityType'])) {
        $this->validityType = $vals['validityType'];
      }
      if (isset($vals['addedToCommandLine'])) {
        $this->addedToCommandLine = $vals['addedToCommandLine'];
      }
      if (isset($vals['dataMovement'])) {
        $this->dataMovement = $vals['dataMovement'];
      }
      if (isset($vals['dataNameLocation'])) {
        $this->dataNameLocation = $vals['dataNameLocation'];
      }
    }
  }

  public function getName() {
    return 'OutputDataObjectType';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->name);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->value);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->type);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->validityType);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::I32) {
            $xfer += $input->readI32($this->addedToCommandLine);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::BOOL) {
            $xfer += $input->readBool($this->dataMovement);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 7:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->dataNameLocation);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('OutputDataObjectType');
    if ($this->name !== null) {
      $xfer += $output->writeFieldBegin('name', TType::STRING, 1);
      $xfer += $output->writeString($this->name);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->value !== null) {
      $xfer += $output->writeFieldBegin('value', TType::STRING, 2);
      $xfer += $output->writeString($this->value);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->type !== null) {
      $xfer += $output->writeFieldBegin('type', TType::I32, 3);
      $xfer += $output->writeI32($this->type);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->validityType !== null) {
      $xfer += $output->writeFieldBegin('validityType', TType::I32, 4);
      $xfer += $output->writeI32($this->validityType);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->addedToCommandLine !== null) {
      $xfer += $output->writeFieldBegin('addedToCommandLine', TType::I32, 5);
      $xfer += $output->writeI32($this->addedToCommandLine);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->dataMovement !== null) {
      $xfer += $output->writeFieldBegin('dataMovement', TType::BOOL, 6);
      $xfer += $output->writeBool($this->dataMovement);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->dataNameLocation !== null) {
      $xfer += $output->writeFieldBegin('dataNameLocation', TType::STRING, 7);
      $xfer += $output->writeString($this->dataNameLocation);
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

class ApplicationInterfaceDescription {
  static $_TSPEC;

  public $applicationInterfaceId = "DO_NOT_SET_AT_CLIENTS";
  public $applicationName = null;
  public $applicationDescription = null;
  public $applicationModules = null;
  public $applicationInputs = null;
  public $applicationOutputs = null;

  public function __construct($vals=null) {
    if (!isset(self::$_TSPEC)) {
      self::$_TSPEC = array(
        1 => array(
          'var' => 'applicationInterfaceId',
          'type' => TType::STRING,
          ),
        2 => array(
          'var' => 'applicationName',
          'type' => TType::STRING,
          ),
        3 => array(
          'var' => 'applicationDescription',
          'type' => TType::STRING,
          ),
        4 => array(
          'var' => 'applicationModules',
          'type' => TType::LST,
          'etype' => TType::STRING,
          'elem' => array(
            'type' => TType::STRING,
            ),
          ),
        5 => array(
          'var' => 'applicationInputs',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Airavata\Model\AppCatalog\AppInterface\InputDataObjectType',
            ),
          ),
        6 => array(
          'var' => 'applicationOutputs',
          'type' => TType::LST,
          'etype' => TType::STRUCT,
          'elem' => array(
            'type' => TType::STRUCT,
            'class' => '\Airavata\Model\AppCatalog\AppInterface\OutputDataObjectType',
            ),
          ),
        );
    }
    if (is_array($vals)) {
      if (isset($vals['applicationInterfaceId'])) {
        $this->applicationInterfaceId = $vals['applicationInterfaceId'];
      }
      if (isset($vals['applicationName'])) {
        $this->applicationName = $vals['applicationName'];
      }
      if (isset($vals['applicationDescription'])) {
        $this->applicationDescription = $vals['applicationDescription'];
      }
      if (isset($vals['applicationModules'])) {
        $this->applicationModules = $vals['applicationModules'];
      }
      if (isset($vals['applicationInputs'])) {
        $this->applicationInputs = $vals['applicationInputs'];
      }
      if (isset($vals['applicationOutputs'])) {
        $this->applicationOutputs = $vals['applicationOutputs'];
      }
    }
  }

  public function getName() {
    return 'ApplicationInterfaceDescription';
  }

  public function read($input)
  {
    $xfer = 0;
    $fname = null;
    $ftype = 0;
    $fid = 0;
    $xfer += $input->readStructBegin($fname);
    while (true)
    {
      $xfer += $input->readFieldBegin($fname, $ftype, $fid);
      if ($ftype == TType::STOP) {
        break;
      }
      switch ($fid)
      {
        case 1:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->applicationInterfaceId);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 2:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->applicationName);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 3:
          if ($ftype == TType::STRING) {
            $xfer += $input->readString($this->applicationDescription);
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 4:
          if ($ftype == TType::LST) {
            $this->applicationModules = array();
            $_size0 = 0;
            $_etype3 = 0;
            $xfer += $input->readListBegin($_etype3, $_size0);
            for ($_i4 = 0; $_i4 < $_size0; ++$_i4)
            {
              $elem5 = null;
              $xfer += $input->readString($elem5);
              $this->applicationModules []= $elem5;
            }
            $xfer += $input->readListEnd();
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 5:
          if ($ftype == TType::LST) {
            $this->applicationInputs = array();
            $_size6 = 0;
            $_etype9 = 0;
            $xfer += $input->readListBegin($_etype9, $_size6);
            for ($_i10 = 0; $_i10 < $_size6; ++$_i10)
            {
              $elem11 = null;
              $elem11 = new \Airavata\Model\AppCatalog\AppInterface\InputDataObjectType();
              $xfer += $elem11->read($input);
              $this->applicationInputs []= $elem11;
            }
            $xfer += $input->readListEnd();
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        case 6:
          if ($ftype == TType::LST) {
            $this->applicationOutputs = array();
            $_size12 = 0;
            $_etype15 = 0;
            $xfer += $input->readListBegin($_etype15, $_size12);
            for ($_i16 = 0; $_i16 < $_size12; ++$_i16)
            {
              $elem17 = null;
              $elem17 = new \Airavata\Model\AppCatalog\AppInterface\OutputDataObjectType();
              $xfer += $elem17->read($input);
              $this->applicationOutputs []= $elem17;
            }
            $xfer += $input->readListEnd();
          } else {
            $xfer += $input->skip($ftype);
          }
          break;
        default:
          $xfer += $input->skip($ftype);
          break;
      }
      $xfer += $input->readFieldEnd();
    }
    $xfer += $input->readStructEnd();
    return $xfer;
  }

  public function write($output) {
    $xfer = 0;
    $xfer += $output->writeStructBegin('ApplicationInterfaceDescription');
    if ($this->applicationInterfaceId !== null) {
      $xfer += $output->writeFieldBegin('applicationInterfaceId', TType::STRING, 1);
      $xfer += $output->writeString($this->applicationInterfaceId);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationName !== null) {
      $xfer += $output->writeFieldBegin('applicationName', TType::STRING, 2);
      $xfer += $output->writeString($this->applicationName);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationDescription !== null) {
      $xfer += $output->writeFieldBegin('applicationDescription', TType::STRING, 3);
      $xfer += $output->writeString($this->applicationDescription);
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationModules !== null) {
      if (!is_array($this->applicationModules)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('applicationModules', TType::LST, 4);
      {
        $output->writeListBegin(TType::STRING, count($this->applicationModules));
        {
          foreach ($this->applicationModules as $iter18)
          {
            $xfer += $output->writeString($iter18);
          }
        }
        $output->writeListEnd();
      }
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationInputs !== null) {
      if (!is_array($this->applicationInputs)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('applicationInputs', TType::LST, 5);
      {
        $output->writeListBegin(TType::STRUCT, count($this->applicationInputs));
        {
          foreach ($this->applicationInputs as $iter19)
          {
            $xfer += $iter19->write($output);
          }
        }
        $output->writeListEnd();
      }
      $xfer += $output->writeFieldEnd();
    }
    if ($this->applicationOutputs !== null) {
      if (!is_array($this->applicationOutputs)) {
        throw new TProtocolException('Bad type in structure.', TProtocolException::INVALID_DATA);
      }
      $xfer += $output->writeFieldBegin('applicationOutputs', TType::LST, 6);
      {
        $output->writeListBegin(TType::STRUCT, count($this->applicationOutputs));
        {
          foreach ($this->applicationOutputs as $iter20)
          {
            $xfer += $iter20->write($output);
          }
        }
        $output->writeListEnd();
      }
      $xfer += $output->writeFieldEnd();
    }
    $xfer += $output->writeFieldStop();
    $xfer += $output->writeStructEnd();
    return $xfer;
  }

}

$GLOBALS['applicationInterfaceModel_CONSTANTS']['DEFAULT_ID'] = "DO_NOT_SET_AT_CLIENTS";


