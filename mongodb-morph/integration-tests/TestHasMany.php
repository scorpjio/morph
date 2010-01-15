<?php
/**
 * @author Jonathan Moss <xirisr@gmail.com>
 * @copyright 2010 Jonathan Moss
 */

require_once dirname(__FILE__).'/../Morph.phar';
require_once dirname(__FILE__).'/MongoTestCase.php';
require_once dirname(__FILE__).'/test-objects/HasManyParent.php';
require_once dirname(__FILE__).'/test-objects/Child.php';

class TestHasMany extends MongoTestCase
{

    public function setUp()
    {
        parent::setUp();
        Morph_Storage::init($this->db);
    }

    public function tearDown()
    {
        parent::tearDown();
        Morph_Storage::deInit();
    }

    public function testStoresParentAndChildren()
    {
        $parent = new HasManyParent();
        $parent->Name = 'Has Many Parent';

        $child1 = new Child();
        $child1->Name = 'Child1';

        $parent->Children[] = $child1;

        $child2 = new Child();
        $child2->Name = 'Child2';

        $parent->Children[] = $child2;

        $parent->save();
        $this->assertCollectionExists('HasManyParent');
        $this->assertCollectionExists('Child');

        $this->assertDocumentExists('HasManyParent', $parent->id());
        $this->assertDocumentExists('Child', $child1->id());
        $this->assertDocumentExists('Child', $child2->id());

    }

}