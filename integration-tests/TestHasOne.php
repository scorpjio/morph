<?php
/**
 * @author Jonathan Moss <xirisr@gmail.com>
 * @copyright 2010 Jonathan Moss
 * @package Morph
 */

require_once dirname(__FILE__).'/../Morph.phar';
require_once dirname(__FILE__).'/MongoUnit/TestCase.php';
require_once dirname(__FILE__).'/test-objects/HasOneParent.php';
require_once dirname(__FILE__).'/test-objects/Child.php';

/**
 * @package Morph
 */
class TestHasOne extends MongoUnit_TestCase
{

    public function setup()
    {
        parent::setup();
        Morph_Storage::init($this->getDatabase());
    }

    public function tearDown()
    {
        parent::tearDown();
        Morph_Storage::deInit();
    }

    public function testStoresParentAndChild()
    {
        $parent = new HasOneParent();
        $parent->Name = 'Has One Parent';

        $child = new Child();
        $child->Name = 'Child';

        $parent->Child = $child;

        $parent->save();
        $this->assertCollectionExists('HasOneParent');
        $this->assertCollectionExists('Child');

        $this->assertDocumentExists('HasOneParent', $parent->id());
        $this->assertDocumentExists('Child', $child->id());

    }

        public function testStoresReplacementChild()
    {
        $parent = new HasOneParent();
        $parent->Name = 'Has One Parent';

        $child = new Child();
        $child->Name = 'Child';

        $parent->Child = $child;

        $parent->save();
        $this->assertCollectionExists('HasOneParent');
        $this->assertCollectionExists('Child');

        $this->assertDocumentExists('HasOneParent', $parent->id());
        $this->assertDocumentExists('Child', $child->id());

        //now for the second child
        $child2 = new Child();
        $child2->Name = 'Child2';
        $parent->Child = $child2;
        $parent->save();
        $this->assertDocumentExists('Child', $child2->id());

    }

}