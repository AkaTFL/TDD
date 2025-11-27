<!-- Code effectué par Hugp Martins -->
<?php
    use PHPUnit\Framework\TestCase;

    require_once 'src/Account.php';
    require_once 'src/Teenager.php';
    require_once 'src/Parents.php';

    class AccountTest extends TestCase
    {
        private Parents $parents;
        
        protected function setUp(): void
        {
            $account = new Account();
            $this->parents = new Parents($account);
        }
        
        public function testImplementsCountable()
        {
            $this->assertInstanceOf(Countable::class, $this->parents);
        }

        public function testAddTeenager()
        {
            $account = new Account();
            $teenager = $this->parents->addTeenager('John', $account);
            
            $this->assertInstanceOf(Teenager::class, $teenager);
            $this->assertEquals(1, $this->parents->count());
        }

        public function testRemoveTeenager()
        {
            // Arrange
            $account = new Account();
            $this->parents->addTeenager('John', $account);
            
            // Act
            $removedTeenager = $this->parents->removeTeenager('John');
            
            // Assert
            $this->assertInstanceOf(Teenager::class, $removedTeenager);
            $this->assertEquals(0, $this->parents->count());
        }

        public function testEditWeeklyAllowance()
        {
            // Arrange
            $account = new Account();
            $teenager = $this->parents->addTeenager('John', $account);
            
            // Act
            $result = $this->parents->editWeeklyAllowance('John', 15, 'Monday');
            
            // Assert
            $this->assertEquals(15, $result); // ou $this->assertTrue($result) si c'est un booléen
        }

        public function testDepositMoney()
        {
            // Arrange
            $account = new Account();
            $teenager = $this->parents->addTeenager('John', $account);
            
            // Act
            $newBalance = $this->parents->depositMoney($teenager, 50);
            
            // Assert
            $this->assertEquals(50, $newBalance);
        }

        public function testWithdrawMoney()
        {
            // Arrange
            $account = new Account();
            $teenager = $this->parents->addTeenager('John', $account);
            $this->parents->depositMoney($teenager, 50);
            
            // Act
            $remainingBalance = $this->parents->withdrawMoney($teenager, 20);
            
            // Assert
            $this->assertEquals(30, $remainingBalance); // 50 - 20 = 30
        }

        public function testGetExpensesReport()
        {
            // Arrange
            $account = new Account();
            $teenager = $this->parents->addTeenager('John', $account);
            
            // Act
            $report = $this->parents->getExpensesReport($teenager);
            
            // Assert
            $this->assertIsArray($report);
            $this->assertEmpty($report);
        }
    }
?>