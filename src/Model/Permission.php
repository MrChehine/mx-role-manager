<?php

namespace MxRoleManager\Model;

class Permission
{

    private ?string $id;
    private ?string $name;
    private ?string $description;
    private ?string $className;
    private ?string $methodName;
    private \DateTime $createdAt;
    private ?\DateTime $updatedAt;

    /**
     * @param string|null $name
     * @param string|null $description
     * @param string|null $className
     * @param string|null $methodName
     */
    public function __construct(?string $name = null, ?string $description = null, ?string $className = null, ?string $methodName = null)
    {
        $this->name = $name;
        $this->description = $description;
        $this->className = $className;
        $this->methodName = $methodName;
    }


    public function hydrate($data) : void
    {
        foreach ($data as $attribute => $value) {
            $method = 'set'.str_replace(' ', '', ucwords(str_replace('_', ' ', $attribute)));
            if (is_callable(array($this, $method))) {
                $this->$method($value);
            }
        }
    }

    /**
     * @return string|null
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return string|null
     */
    public function getClassName(): ?string
    {
        return $this->className;
    }

    /**
     * @param string $className
     */
    public function setClassName(string $className): void
    {
        $this->className = $className;
    }

    /**
     * @return string|null
     */
    public function getMethodName(): ?string
    {
        return $this->methodName;
    }

    /**
     * @param string $methodName
     */
    public function setMethodName(string $methodName): void
    {
        $this->methodName = $methodName;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param string|null $createdAt
     * @throws \Exception
     */
    public function setCreatedAt(?string $createdAt): void
    {
        if($createdAt !== null)
        {
            $this->createdAt = new \DateTime($createdAt);
        }
    }

    /**
     * @return \DateTime|null
     */
    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param string|null $updatedAt
     * @throws \Exception
     */
    public function setUpdatedAt(?string $updatedAt): void
    {
        if($updatedAt !== null)
        {
            $this->updatedAt = new \DateTime($updatedAt);
        }
    }

}