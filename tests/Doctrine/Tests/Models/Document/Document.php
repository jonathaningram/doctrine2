<?php

namespace Doctrine\Tests\Models\Document;

/**
 * @Entity
 * @Table(name="document")
 * @InheritanceType("SINGLE_TABLE")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"document"="Document", "image_document"="ImageDocument"})
 */
class Document
{
    /**
     * @Column(name="id", type="integer")
     * @Id
     * @GeneratedValue(strategy="AUTO")
     */
    private $id;

    protected $dataClass = null;

    /**
     * @OneToOne(targetEntity="DocumentData", cascade={"persist", "remove"})
     * @JoinColumn(nullable=true, onDelete="cascade")
     */
    protected $data = null;

    /**
     * @Column(type="integer")
     */
    private $version;

    public function getId()
    {
        return $this->id;
    }

    public function setData(DocumentData $data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        if (null === $this->data && null !== ($dataClass = $this->dataClass) && class_exists($dataClass)) {
            $this->setData(new $dataClass());
        }

        return $this->data;
    }

    public function getVersion()
    {
        return $this->version;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }
}
